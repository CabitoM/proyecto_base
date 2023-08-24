<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

use App\Models\Configuracion\Rol;
use Illuminate\Auth\Access\Response;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->registerPolicies();
        Gate::define('privilegio', function ($usuario, $id_rol, ...$privilegios) {
          if($usuario->super_user=="Y"){
            return Response::allow();
          }
          else{
            $permitir=false;
            foreach($privilegios as $privilegio){
              $ob=Rol::select("roles.*")
              ->join("rol_permisos as rp","roles.id","=","rp.id_rol")
              ->join("permisos as p","rp.id_permiso","=","p.id")
              ->where([
                ["p.name_guard",$privilegio],
                ["roles.id",$id_rol]
              ])->get()->count();
              if($ob>0){
                $permitir=true;
                break;
              }
            }
            return $permitir? Response::allow(): Response::deny('No tienes acceso a este sitio.');
          }

        });

        Gate::define('permitido', function ($usuario, $id_rol, $privilegio) {
          if($usuario->super_user=="Y"){
            return true;
          }
          else{
            $ob=Rol::select("roles.*")
            ->join("rol_permisos as rp","roles.id","=","rp.id_rol")
            ->join("permisos as p","rp.id_permiso","=","p.id")
            ->where([
              ["p.name_guard",$privilegio],
              ["roles.id",$id_rol]
            ])->get()->count();
            return $ob>0? true: false;
          }

        });
        //
    }
}

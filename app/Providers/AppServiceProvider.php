<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use stdClass;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        //view()->share(["info"=>getInfo()]);
        /////layouts.app-master para el login separar los css y js y ahora si funcionara solo para cuando este logueado
        view()->composer('*', function($view)/// * todas las vistas si solo aplica para una se le pone el nombre de la vista
        {
            if (Auth::check()) {
                /// si tiene sesion mandamos el valor del usuario en sesion para el menu
                view()->share(["info"=>Auth::user()]);
            }else {
                /// si no hay sesion creamos el objeto con la unica variable que usamos en donde no tiene sesion activa
                $data=new stdClass();
                $data->vertical="Y";
                view()->share(["info"=>$data]);
             }
        });

    }
}

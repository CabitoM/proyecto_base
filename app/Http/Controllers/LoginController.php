<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\Configuracion\RolPermiso;
use App\Models\Configuracion\RolUsuario;
use App\Models\Sucursal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
    //
    public function show(){
        if(Auth::check()){
            return redirect()->to("/home");
        }
        return view("auth.login");
    }
    public function login(LoginRequest $request){
        $credenciales=$request->getCredentials();
        //dd($credenciales);
        if(!Auth::validate($credenciales)){
            return redirect()->to("/login")->withErrors("Usuario o contraseña incorrectos");
        }
        $user = Auth::getProvider()->retrieveByCredentials($credenciales);
        Auth::login($user);
        return $this->autenticado($request,$user);
    }
    public function autenticado(Request $request,$user){
        return redirect("/elegir_sucursal");
    }
    public function elegir_sucursal(){
        if(empty(Auth::user()->id)){
            return redirect('/login');
        }
        $sucursales = RolUsuario::select('s.nombre as sucursal', 's.id')
        ->Join('sucursales as s', 'rol_usuario.id_sucursal', '=', 's.id')
        ->where([
            ['rol_usuario.acceso','Y'],
            ['rol_usuario.status','Activo'],
            ['rol_usuario.id_usuario',Auth::user()->id]
        ])
        ->get();

        if($sucursales->count()<1){
            abort(403, 'No estas autorizado para acceder al sistema.');
        }else if($sucursales->count()==1){
            return $this->setSucu($sucursales[0]->id);
        }else{
            return view("auth.seleccionar_sucursal",["sucursales"=>$sucursales]);
        }


    }
    public function setSucu($idSucu){
        session(['id_sucursal' => $idSucu]);
        if(session()->has('id_sucursal') and session('id_sucursal')>0){
            $user = Auth::user();
            $rol=RolUsuario::select("r.nombre","rol_usuario.*")
            ->join('roles as r', 'rol_usuario.id_rol', '=', 'r.id')
            ->where([
                ['rol_usuario.acceso','Y'],
                ['rol_usuario.status','Activo'],
                ['rol_usuario.id_usuario',$user->id],
                ['rol_usuario.id_sucursal',session("id_sucursal")]
            ])->firstOrFail();
            //dd($rol->toSql());
            $num_roles = $rol->count();
            session(["acceso"=>$rol->acceso]);
            session(["id_rol"=>$rol->id_rol]);
            session(["rol"=>$rol->nombre]);
            if($num_roles==0 or $num_roles==null){
                abort(401, 'No estas autorizado para acceder esta Sucursal.');
            }
            //sucursal name y plaza
            $sucursal=Sucursal::select("p.name as plaza","sucursales.nombre")
            ->join('cat_plaza as p', 'sucursales.id_plaza', '=', 'p.id')
            ->where('sucursales.id','=',session("id_sucursal"))->firstOrFail();
            session(["plaza"=>$sucursal->plaza]);
            session(["sucursal"=>$sucursal->nombre]);
            $num_sucursales = $sucursal->count();
            //dd($num_sucursales);
            if($num_sucursales==0 or $num_sucursales==null){
                abort(401, 'No estas autorizado para acceder a la sucursal.');
            }
            $privilegios=RolPermiso::select("p.name_guard")->where([
                ['id_rol',$rol->id_rol]])
                ->join("permisos as p","rol_permisos.id_permiso","=","p.id")
                ->get()->keyBy('name_guard');
                session(["privilegios"=>$privilegios]);
                return redirect('/home');
        }
        else{
            if(!empty(Auth::user()->id) or Auth::user()->id<1){
                return redirect('/login');
            }
        }
    }

    public function seleccionar_sucursal(Request $request){
        return $this->setSucu($request->input('sucursal'));
    }

}

<?php

namespace App\Http\Controllers\Usuario;

use App\Classes\CLSMovimientos;
use App\Http\Controllers\Controller;
use App\Http\Requests\UsuarioRequest;
use App\Models\Configuracion\CatPlaza;
use App\Models\Configuracion\Rol;
use App\Models\Configuracion\RolUsuario;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    //
    public function getRoles(){
        return Rol::where('status','Activo')       
        ->orderby('nombre')
        //->where("super_user",0)      
        ->get();
       
    }
    public function datos_usuario($id){
        $plazas=CatPlaza::select("cat_plaza.*")
        ->where('cat_plaza.status','Activo')            
        ->orderby('cat_plaza.name')      
        ->with("sucursales")
        ->get(); 
        $usuario = User::findOrFail($id);
        $usuario_rol = RolUsuario::where("status","Activo")     
        ->where("id_usuario",$id)     
        ->get();
        $arrayRoleUser["perfil"]=[];
        $arrayRoleUser["chk"]=[];
        foreach($usuario_rol as $ru){
            array_push($arrayRoleUser["perfil"],$ru->id_sucursal."-".$ru->id_rol);
            array_push($arrayRoleUser["chk"],$ru->id_sucursal."-".$ru->acceso);
        }
        //dd($arrayRoleUser);
        return [
            "modulo"=>"E",
            "usuario"=>$usuario,
            "plazas"=>$plazas,
            "arrayRoleUser"=>$arrayRoleUser,
            "roles"=>$this->getRoles(),
        ];
    }
    public function listado(){
        if(Auth::user()->super_user=="Y"){
            $usuario = User::select("users.*","u.name as usuario_alta")
            ->leftjoin("users as u","users.id_usuario","=","u.id")
            ->where("users.status","Activo")->get();
        }
        else{
            $usuario = User::select("users.*","u.name as usuario_alta")
            ->join("users as u","users.id_usuario","=","u.id")
            ->where("users.status","Activo")->where("users.super_user","N")->get();
        }
        
        return view("Configuraciones.usuario.index",['data' => $usuario,]);
    }
    public function ver($id){
        return view("Configuraciones.usuario.nuevo",$this->datos_usuario($id));
    }
    public function nuevo(){
        $plazas=CatPlaza::select("cat_plaza.*")
        //->join("cat_sucursal as s","cat_plaza.id","=","s.plaza_id")
        ->where('cat_plaza.status','Activo')            
        ->orderby('cat_plaza.name')      
        ->with("sucursales")
        ->get(); 
        return view("Configuraciones.usuario.nuevo",[
            "modulo"=>"A",
            "plazas"=>$plazas,
            "roles"=>$this->getRoles(),
        ]);
    }
    public function guardar(UsuarioRequest $request){
        try { 
            DB::transaction(function () use($request) { 
                $user=Auth::user();
                $usuario=new User(); 
                $usuario->name=$request->nombre;
                $usuario->status="Activo";
                $usuario->id_usuario=$user->id;
                $usuario->username=$request->username;
                $usuario->email=$request->correo;
                $usuario->telefono=$request->telefono;
                $usuario->direccion=$request->direccion;
                $usuario->password=Hash::make($request->password);
                $usuario->save();
            });
            return response()->json([
                "respuesta"=>1,
                "mensaje"=>"Se Guardó el Usuario",           
            ]);
        } catch (\Exception $e) {      
            abort(400,$e->getMessage());
        }
    }
    public function editar(UsuarioRequest $request){
        
        try { 
            $antes=[];
            $despues=[];
            DB::transaction(function () use($request,&$antes,&$despues) {  
                $id_usuario=Auth::user()->id;
                $id_reg=$request->id_user;
                /// se instancia la clase y se buscan los datos con ese id
                $usuario=User::findOrFail($id_reg);
                $antes=$usuario->toJson();
                
                $usuario->name=$request->nombre;
                $usuario->id_usuario=$id_usuario;
                $usuario->username=$request->username;
                $usuario->email=$request->correo;
                $usuario->telefono=$request->telefono;
                $usuario->direccion=$request->direccion;
                if(!empty($request->input("password"))){
                    $usuario->password=Hash::make($request->password);
                }
                $usuario->save();
                $despues=User::findOrFail($id_reg)->toJson();

                $sucurlsales_rol=json_decode($request->input('jsonAcceso'));//llos accesos y sucursales que se le dieron
                RolUsuario::where([
                    ['id_usuario',$usuario->id],
                ])->update(['status'=>'Inactivo']);
                //dd($sucurlsales_rol);
                foreach ( $sucurlsales_rol as $sucursal) {
                    //dd($sucursal);
                    $update_rol=RolUsuario::where([
                        ["id_usuario",$usuario->id],
                        ["id_sucursal",$sucursal->id_sucursal],
                        ["acceso",$sucursal->acceso],
                    ])->update([
                        "status"=>"Activo",
                        "id_rol"=>$sucursal->id_rol,
                    ]);
                    //dd($update_rol);
                    if($update_rol==0){// no existe y se debe dar de alta
                        $nuevo_rol= new RolUsuario();
                        $nuevo_rol->status="Activo";
                        $nuevo_rol->id_rol=$sucursal->id_rol;
                        $nuevo_rol->id_usuario=$usuario->id;
                        $nuevo_rol->id_sucursal=$sucursal->id_sucursal;
                        $nuevo_rol->acceso=$sucursal->acceso;
                        $nuevo_rol->save();
                    }
                }
                /*
                (new CLSMovimientos((object)[
                    "tabla"=>"user",
                    "id_relacion"=>$id_reg,
                    "tipo"=>"editar",
                    "antes"=>$antes,
                    "despues"=>$despues,
                    "comentario"=>"Actualización de Usuario",
                ]))->create(); 
                */
            });
            return response()->json([
                "respuesta"=>1,
                "mensaje"=>"Se guardaron los datos",           
            ]);
        } catch (\Exception $e) {      
            abort(400,$e->getMessage());
        }
    }
    public function eliminar(Request $request){
        try { 
            DB::transaction(function () use($request) { 
                $id_reg=$request->id_reg;
                $usuario=User::findOrFail($id_reg);
                $usuario->status="Inactivo";
                $usuario->save();
                (new CLSMovimientos((object)[
                    "tabla"=>"user",
                    "id_relacion"=>$id_reg,
                    "tipo"=>"eliminar",
                    "antes"=>"",
                    "despues"=>"",
                    "comentario"=>"Se eliminó usuario",
                ]))->create(); 
            });
            return response()->json([
                "respuesta"=>1,
                "mensaje"=>"Se Eliminó el Usuario",           
            ]);
        } catch (\Exception $e) {      
            abort(400,$e->getMessage());
        }
    }  
    public function modal_ver(Request $request){
        return view("Configuraciones.usuario.modal_ver",$this->datos_usuario($request->id));
    }
    public function perfil(){
        return view("Configuraciones.usuario.perfil",[
            "usuario"=> Auth::user()
        ]);
    }
}

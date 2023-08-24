<?php

namespace App\Http\Controllers\Configuraciones;

use App\Classes\CLSMovimientos;
use App\Http\Controllers\Controller;
use App\Models\Configuracion\Permiso;
use App\Models\Configuracion\Rol;
use App\Models\Configuracion\RolMenu;
use App\Models\Configuracion\RolPermiso;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
class RolController extends Controller
{
    //
    public function nuevo (){
        Gate::authorize('privilegio', [session('id_rol'), "alta_rol"]);
        return view("Configuraciones.Rol.nuevo",[
            "modulo"=>"A",
            "arMenuSelected"=>[],       
            "arPermissionSelected"=>[],  
        ]);
    }
    public function listado(){
        Gate::authorize('privilegio', [session('id_rol'), "listado_rol"]);
        $roles=Rol::select("roles.*","u.name as usuario_alta")
        ->join("users as u","roles.id_usuario","=","u.id")
        ->where("roles.status","Activo")->get();
        return view("Configuraciones.Rol.listado",["roles"=>$roles]);
    }
    public function eliminar(Request $request){
        Gate::authorize('privilegio', [session('id_rol'), "eliminar_rol"]);
        DB::begintransaction();
        try { 
            $id_reg=$request->id_reg;
            $rol=Rol::findOrFail($id_reg);
            $rol->status="Inactivo";
            $rol->save();
            (new CLSMovimientos((object)[
                "tabla"=>"Rol",
                "id_relacion"=>$id_reg,
                "tipo"=>"eliminar",
                "antes"=>"",
                "despues"=>"",
                "comentario"=>"Se eliminó Rol",
            ]))->create(); 
            DB::commit();
            return response()->json([
                "respuesta"=>1,
                "mensaje"=>"Se Eliminó el registro",           
            ]);
        } catch (\Exception $e) {
            DB::rollBack();        
            abort(400,$e->getMessage());
        }
    }
    public function ver($id){
        ///siempre manda como primer parametro el usuario que esta logueado
        Gate::authorize('privilegio', [session('id_rol'), "editar_rol"]);
        $rol = Rol::findOrFail($id);     
        $obMenu=new RolMenu();
        $arMenuSelected=$obMenu->relRolMenu($id)->get()->pluck('id')->toArray();
        $obPermisos=new RolPermiso();
        $arPermisosSelected=$obPermisos->RolPermisos($id)->get()->pluck('id')->toArray();
        return view("Configuraciones.Rol.nuevo",[
            "modulo"=>"E",
            "rol"=>$rol,
            "arMenuSelected"=> $arMenuSelected,       
            "arPermissionSelected"=>$arPermisosSelected,  
        ]);
    }
    public function guardar(Request $request){
        Gate::authorize('privilegio', [session('id_rol'), "alta_rol"]);
        DB::begintransaction();
        try{
            $usuario=Auth::user();
            $rol=new Rol();
            $rol->nombre=$request->nombre;
            $rol->name_guard=$request->name_guard;
            $rol->id_usuario=$usuario->id;
            $rol->status='Activo';
            $rol->save();
            $id = $rol->id;
            $menu = json_decode($request->seleccionados);
            foreach ($menu as $item) {
                if($item->tipo==0){
                    ///activarle el menu
                    $rolMenu=Menu::findOrFail($item->id);                  
                    $rolMenu=new RolMenu();
                    $rolMenu->id_rol=$id;
                    $rolMenu->id_menu=$item->id;                 
                    $rolMenu->status='Activo';
                    $rolMenu->id_usuario=$usuario->id;    
                    $rolMenu->save();
                }else if($item->tipo==1){
                    /// activarle el permiso
                    $RolPermiso=Permiso::findOrFail($item->id);                  
                    $RolPermiso=new RolPermiso();
                    $RolPermiso->id_rol=$id;
                    $RolPermiso->id_permiso=$item->id;                 
                    $RolPermiso->status='Activo';
                    $RolPermiso->id_usuario=$usuario->id;    
                    $RolPermiso->save();     
                }

            }
            DB::commit();
            return response()->json([
                "respuesta"=>1,
                "mensaje"=>"Se Guardó El Rol correctamente",           
            ]);
        }catch(\Exception $e){
            DB::rollBack();
            abort(400,$e->getMessage());
        }
    }
    public function editar(Request $request){
        Gate::authorize('privilegio', [session('id_rol'), "editar_rol"]);
        DB::begintransaction();
        try{
            $usuario = Auth::user();
            $id=($request->id_rol);

            $rol=Rol::findOrFail($id);
            $antes=$rol->toJson();
            $rol->nombre=$request->nombre;
            $rol->name_guard=$request->name_guard;
            $rol->save();

            RolMenu::where("id_rol",$id)->delete();
            RolPermiso::where("id_rol",$id)->delete();
            $menu = json_decode($request->seleccionados);     
            foreach ($menu as $item) {
                if($item->tipo==0){
                    ///activarle el menu
                    $rolMenu=Menu::findOrFail($item->id);                  
                    $rolMenu=new RolMenu();
                    $rolMenu->id_rol=$id;
                    $rolMenu->id_menu=$item->id;                 
                    $rolMenu->status='Activo';
                    $rolMenu->id_usuario=$usuario->id;    
                    $rolMenu->save();
                }else if($item->tipo==1){
                    /// activarle el permiso
                    $RolPermiso=Permiso::findOrFail($item->id);                  
                    $RolPermiso=new RolPermiso();
                    $RolPermiso->id_rol=$id;
                    $RolPermiso->id_permiso=$item->id;                 
                    $RolPermiso->status='Activo';
                    $RolPermiso->id_usuario=$usuario->id;    
                    $RolPermiso->save();     
                }

            }
            $despues=Rol::findOrFail($id)->toJson(); 
            (new CLSMovimientos((object)[
                "tabla"=>"rol",
                "id_relacion"=>$id,
                "tipo"=>"editar",
                "antes"=>&$antes,
                "despues"=>&$despues,
                "comentario"=>"Actualización de Sucursal",
            ]))->create(); 
            DB::commit();
            return response()->json([
                "respuesta"=>1,
                "mensaje"=>"Se Guardó El Rol correctamente",           
            ]);
        }catch(\Exception $e){
            DB::rollBack();
            abort(400,$e->getMessage());
        }
    }
    public function permisos(Request $request){
        $parent=$request->parent;
        $data = array();

        $states = array(
            "success",
            "info",
            "danger",
            "warning"
        );
        if($parent=="#"){
            $parent=0;
        }
        $menu= new Menu();
        $opciones = Menu::with("permisos_menu","hijos")->where("id_pertenece", $parent )->get();
        //dd($opciones);
        foreach($opciones as $opcion) {
            $hijos=$opcion->hijos()->count();
            $data[] =[ 
                "id" => $opcion["id"],
                "text" => $opcion["titulo"],
                "icon" => $opcion["icono"],
                "children" => ($hijos > 0?true:false),
                "type" => "root"
            ];
        }
        

        return response()->json($data);
    }
}

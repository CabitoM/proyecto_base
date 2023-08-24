<?php
namespace App\Http\Controllers\Configuraciones;

use App\Classes\CLSMovimientos;
use App\Http\Controllers\Controller;
use App\Models\Configuracion\Permiso;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
class PermisoController extends Controller{
    public function listado(){
        Gate::authorize('privilegio', [session('id_rol'), "listado_privilegios"]);
        $permisos= Permiso::select("permisos.*","u.name as usuario_alta", "m.titulo as menu")
        ->join("users as u","permisos.id_usuario","=","u.id")
        ->leftjoin("menu as m", "permisos.id_menu","=","m.id")
        ->where("permisos.status","Activo")->get();
        return view("Configuraciones.Permiso.listado",[
            "data"=>$permisos
        ]);
    }
    public function nuevo(){
        Gate::authorize('privilegio', [session('id_rol'), "alta_privilegio"]);
        $listado_menu=Menu::where("status","Activo")->orderby("titulo")->get();
        return view("Configuraciones.Permiso.nuevo",[
            "modulo"=>"A",
            "menu"=>$listado_menu,
        ]);
    }
    public function ver($id){
        Gate::authorize('privilegio', [session('id_rol'), "editar_privilegio"]);
        $permiso = Permiso::findOrFail($id);
        $listado_menu=Menu::where("status","Activo")->orderby("titulo")->get();
        return view("Configuraciones.Permiso.nuevo",[
            "modulo"=>"E",
            "permiso"=>$permiso,
            "menu"=>$listado_menu,
        ]);
    }
    public function guardar(Request $request){
        Gate::authorize('privilegio', [session('id_rol'), "alta_privilegio"]);
        DB::begintransaction();
        try{
            $permiso= new Permiso();
            $user=Auth::user();
            $permiso->id_usuario=$user->id;
            $permiso->nombre=$request->nombre;
            $permiso->id_menu=$request->id_menu;
            $permiso->name_guard=$request->name_guard;
            $permiso->status="Activo";
            $permiso->save();
             
            DB::commit();
            return response()->json([
                "respuesta"=>1,
                "mensaje"=>"Se guardaron los datos",           
            ]);
        }catch(\Exception $e){
            DB::rollBack();
            abort(400,$e->getMessage());
        }
    }
    public function editar(Request $request){
        Gate::authorize('privilegio', [session('id_rol'), "editar_privilegio"]);
        DB::begintransaction();
        try{
            $id_permiso=$request->id_permiso;
            $permiso= Permiso::findOrfail($id_permiso);
            $antes=$permiso->toJson();
            $user=Auth::user();
            $permiso->id_usuario=$user->id;
            $permiso->nombre=$request->nombre;
            $permiso->id_menu=$request->id_menu;
            $permiso->name_guard=$request->name_guard;
            $permiso->save();
            $despues=Menu::findOrFail($id_permiso)->toJson(); 
                (new CLSMovimientos((object)[
                    "tabla"=>"menu",
                    "id_relacion"=>$id_permiso,
                    "tipo"=>"editar",
                    "antes"=>&$antes,
                    "despues"=>&$despues,
                    "comentario"=>"Actualización de Sucursal",
                ]))->create(); 
            DB::commit();
            return response()->json([
                "respuesta"=>1,
                "mensaje"=>"Se guardaron los datos",           
            ]);
        }catch(\Exception $e){
            DB::rollBack();
            abort(400,$e->getMessage());
        }
    }
    public function eliminar(Request $request){
        Gate::authorize('privilegio', [session('id_rol'), "eliminar_privilegio"]);
        DB::begintransaction();
        try{
            $id_permiso=$request->id_reg;
            $permiso= Permiso::findOrfail($id_permiso);
            $user=Auth::user();
            $permiso->id_usuario=$user->id;
            $permiso->status="Inactivo";
            $permiso->save();
            (new CLSMovimientos((object)[
                "tabla"=>"permisos",
                "id_relacion"=>$id_permiso,
                "tipo"=>"editar",
                "antes"=>"",
                "despues"=>"",
                "comentario"=>"Se elimino el permiso",
            ]))->create(); 
            DB::commit();
            return response()->json([
                "respuesta"=>1,
                "mensaje"=>"Se guardaron los datos",           
            ]);
        }catch(\Exception $e){
            DB::rollBack();
            abort(400,$e->getMessage());
        }
    }
}
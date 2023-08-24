<?php

namespace App\Http\Controllers\Configuraciones;

use App\Classes\CLSMovimientos;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class MenuController extends Controller
{
    //
    public function listado(){
        Gate::authorize('privilegio', [session('id_rol'), "listado_menu"]);
        $menu= Menu:: select("menu.*","u.name as usuario_alta","m.titulo as pertenece")
        ->join("users as u","menu.id_usuario","=","u.id")->leftjoin("menu as m","menu.id_pertenece","=","m.id")
        ->where("menu.status","Activo")->get();
        return view("Configuraciones.menu.listado",["data"=>$menu]);
    }
    public function nuevo(){
        Gate::authorize('privilegio', [session('id_rol'), "alta_menu"]);
        $sel_menus=Menu::where("status","Activo")->orderby("titulo")->get();
        return view("Configuraciones.menu.nuevo",[
            "modulo"=>"A",
            "sel_menus"=>$sel_menus,
            "menu_selected"=>"Menu",
        ]);
    }
    public function guardar(Request $request){
        Gate::authorize('privilegio', [session('id_rol'), "alta_menu"]);
        DB::beginTransaction();
        try {
            $menu= new Menu();
            $user=Auth::user();
            $menu->status="Activo";
            $menu->id_usuario=$user->id;
            $menu->titulo=$request->titulo;
            $menu->id_pertenece=$request->id_pertenece;
            $menu->orden=$request->orden;
            $menu->icono=$request->icono;
            $menu->ruta=$request->ruta;
            $menu->color=$request->color;
            $menu->save();
            DB::commit();
            return response()->json([
                "respuesta"=>1,
                "mensaje"=>"Se guardaron los datos",           
            ]);
        } catch (\Exception $e) {
            DB::rollBack();  
            abort(400,$e->getMessage());
        }
    }
    public function editar(Request $request){
        Gate::authorize('privilegio', [session('id_rol'), "editar_menu"]);
        DB::begintransaction();
        try{
            $id_menu=$request->id_menu;
            $menu= Menu::findOrfail($id_menu);
            $antes=$menu->toJson();
            $user=Auth::user();
            $menu->id_usuario=$user->id;
            $menu->titulo=$request->titulo;
            $menu->id_pertenece=$request->id_pertenece;
            $menu->orden=$request->orden;
            $menu->icono=$request->icono;
            $menu->ruta=$request->ruta;
            $menu->color=$request->color;
            $menu->save();
            $despues=Menu::findOrFail($id_menu)->toJson(); 
                (new CLSMovimientos((object)[
                    "tabla"=>"menu",
                    "id_relacion"=>$id_menu,
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
        DB::begintransaction();
        try { 
            $id_reg=$request->id_reg;
            $rol=Menu::findOrFail($id_reg);
            $rol->status="Inactivo";
            $rol->save();
            (new CLSMovimientos((object)[
                "tabla"=>"Menu",
                "id_relacion"=>$id_reg,
                "tipo"=>"eliminar",
                "antes"=>"",
                "despues"=>"",
                "comentario"=>"Se eliminó Menu",
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
        Gate::authorize('privilegio', [session('id_rol'), "editar_menu"]);
        $menu=Menu::findOrFail($id);
        $sel_menus=Menu::orderby("titulo")->get();
        return view("Configuraciones.menu.nuevo",[
            "modulo"=>"M",
            "sel_menus"=>$sel_menus,
            "menu"=>$menu,
        ]);
    }
}

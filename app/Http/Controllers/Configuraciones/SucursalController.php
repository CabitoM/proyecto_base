<?php

namespace App\Http\Controllers\Configuraciones;

use App\Classes\CLSMovimientos;
use App\Http\Controllers\Controller;
use App\Models\Sucursal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SucursalController extends Controller
{
    public function listado(){
        $sucursal = Sucursal::select("sucursales.*","u.name as usuario_alta")
        ->leftjoin("users as u","sucursales.id_usuario","=","u.id")
        ->where("sucursales.status","Activo")->get();
        
        return view("Configuraciones.sucursal.index",['data' => $sucursal,]);
    }
    public function ver($id_sucursal){
        $sucursal = Sucursal::findOrFail($id_sucursal);
        return view("Configuraciones.sucursal.nueva",[
            "modulo"=>"E",
            "sucursal"=>$sucursal,
        ]);
    }
    public function nueva(){ 
        return view("Configuraciones.sucursal.nueva",[
            "modulo"=>"A",
        ]);
    }
    public function guardar(Request $request){
        DB::begintransaction();
        try{
            $usuario=Auth::user();
            $sucursal=new Sucursal();
            $sucursal->id_usuario=$usuario->id;
            $sucursal->nombre=$request->nombre;
            $sucursal->nombre_comercial=$request->nombre_comercial;
            $sucursal->calle=$request->calle;
            $sucursal->numero=$request->numero;
            $sucursal->colonia=$request->colonia;
            $sucursal->ciudad=$request->ciudad;
            $sucursal->estado=$request->estado;
            $sucursal->cp=$request->cp;
            $sucursal->correo=$request->correo;
            $sucursal->telefono=$request->telefono;
            $sucursal->status="Activo";
            $sucursal->save();
            $id=$sucursal->id;
            $files = $request->file('logotipo');
            if($request->hasFile('logotipo')){
                $imagen=guardar_archivo($files,'assets/images/sucursales/'.$id);
                DB::table('sucursales')->where('id',$id)->update(["logotipo"=>$imagen->datas]);
            } 
            DB::commit();
            return response()->json([
                "respuesta"=>1,
                "mensaje"=>"Se Guardó La Sucursal",           
            ]);
        }catch(\Exception $e){
            DB::rollBack();
            abort(400,$e->getMessage());
        }
    }
    public function editar(Request $request){
        DB::begintransaction();
        try { 
            $antes=[];
            $despues=[];

            $id_usuario=Auth::user()->id;
            $id_sucursal=$request->id_sucursal;
            $sucursal=Sucursal::findOrFail($id_sucursal);
            $antes=$sucursal->toJson();

            $sucursal->id_usuario=$id_usuario;
            $sucursal->nombre=$request->nombre;
            $sucursal->nombre_comercial=$request->nombre_comercial;
            $sucursal->calle=$request->calle;
            $sucursal->numero=$request->numero;
            $sucursal->colonia=$request->colonia;
            $sucursal->ciudad=$request->ciudad;
            $sucursal->estado=$request->estado;
            $sucursal->cp=$request->cp;
            $sucursal->correo=$request->correo;
            $sucursal->telefono=$request->telefono;

            $sucursal->save();
            $files = $request->file('logotipo');
            if($request->hasFile('logotipo')){
                $imagen=guardar_archivo($files,'assets/images/sucursales/'.$id_sucursal);
                DB::table('sucursales')->where('id',$id_sucursal)->update(["logotipo"=>$imagen->datas]);
            } 
            $despues=Sucursal::findOrFail($id_sucursal)->toJson(); 
            (new CLSMovimientos((object)[
                "tabla"=>"sucursal",
                "id_relacion"=>$id_sucursal,
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
        } catch (\Exception $e) {
            DB::rollBack();  
            abort(400,$e->getMessage());
        }
    }
    public function eliminar(Request $request){
        DB::begintransaction();
        try { 
            $id_reg=$request->id_reg;
            $usuario=Sucursal::findOrFail($id_reg);
            $usuario->status="Inactivo";
            $usuario->save();
            (new CLSMovimientos((object)[
                "tabla"=>"sucursales",
                "id_relacion"=>$id_reg,
                "tipo"=>"eliminar",
                "antes"=>"",
                "despues"=>"",
                "comentario"=>"Se eliminó Sucursal",
            ]))->create(); 
            DB::commit();
            return response()->json([
                "respuesta"=>1,
                "mensaje"=>"Se Eliminó el Sucursal",           
            ]);
        } catch (\Exception $e) {
            DB::rollBack();        
            abort(400,$e->getMessage());
        }
    }
    public function getImageDropzone(Request $request){
        $fileList = [];
        $id=($request->input("id"));
        $sucursal=Sucursal::where("id",$id)->first();
   
        if(!empty($sucursal->logotipo)){
            $image_path =  url('/')."/".$sucursal->logotipo;
            
            //$image_path = $sucursal->logotipo;
            $fileList[] = [
                'idA'=>$sucursal->id,         
                'ruta'=> $image_path,
                'server'=> $image_path,
                'name'=>'logotipo',
                'size'=> file::size(public_path()."/".$sucursal->logotipo)
            ];
        }
        return response()->json($fileList);
    }
    public function deleteImageDropzone(Request $request){
        $sucursal=Sucursal::where("id",$request->input("id"))->first();
        $image_path =  public_path()."/".$sucursal->logo_ticket;
        //dd($image_path);
        if(File::exists($image_path)) {
            File::delete($image_path);          
            $sucursal->logotipo='';
            $sucursal->save();
        }else{
            abort(404,'No se pudo eliminar');
        }
        return response()->json(['respuesta'=>1]);
    }
}

<?php namespace App\Classes;

use App\Models\Movimiento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CLSMovimientos 
{
    protected $data; 
    protected $folio;
    public function __construct($data){
        $this->data=$data;
    }
    public function create(){

        $ob_folio= DB::table("folios")->where("status","Activo")->where("tipo","movimiento")->first();
        $folio=$ob_folio->folio;
        DB::table('folios')->where("status","Activo")->where("tipo","movimiento")->increment('folio',1);

        $ob_movimiento=new  Movimiento();
        $ob_movimiento->tabla=$this->data->tabla;
        $ob_movimiento->id_relacion=$this->data->id_relacion;
        $ob_movimiento->antes=$this->data->antes;
        $ob_movimiento->despues=$this->data->despues;
        $ob_movimiento->comentario=$this->data->comentario;
        $ob_movimiento->folio=$folio;
        $ob_movimiento->tipo=$this->data->tipo;
        $ob_movimiento->status='Activo';
        $ob_movimiento->id_sucursal=1;
        $ob_movimiento->id_usuario=Auth::user()->id; //dd($ob_movimiento);
        $ob_movimiento->save(); 
    }
}
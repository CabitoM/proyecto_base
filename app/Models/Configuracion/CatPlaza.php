<?php

namespace App\Models\Configuracion;

use App\Models\Sucursal;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatPlaza extends Model
{
    //use HasFactory;
    protected $table="cat_plaza";

    public function sucursales() {
        return $this->hasMany(Sucursal::class,'id_plaza','id')->where("status","Activo")->orderby('nombre');
    }
}

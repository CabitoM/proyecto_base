<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolMenu extends Model
{
    //use HasFactory;
    protected $table="rol_menu";
    public function relRolMenu($id){
        $where=[
            ['rol_menu.id_rol','=',$id],
        ];
        $menu=RolMenu::select("m.*")
        ->join("menu as m","rol_menu.id_menu","=","m.id")     
        ->where($where);
        return $menu;
    }
}

<?php

namespace App\Models;

use App\Models\Configuracion\Permiso;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    //use HasFactory;
    //protected $fillable = ['title','parent_id'];
    protected $table="menu"; 

    public function permisos_menu(){
        return $this->hasMany(Permiso::class,'id_menu','id')->orderby("nombre");
    } 

    public function parent(){
        return $this->hasOne(Menu::class,'id','id_pertenece')->withDefault();
    } 

    public function hijos(){
        return $this->hasMany(Menu::class,'id_pertenece','id')->orderby("orden");
    }

    public function getChildren($data, $line){
        $children = [];
        foreach ($data as $line1) {
            if ($line['id'] == $line1['id_pertenece']) {
                $children = array_merge($children, [ array_merge($line1, ['submenu' => $this->getChildren($data, $line1) ]) ]);
            }
        }
        return $children;
    }
    public function optionsMenu(){
        return $this->select("menu.*")
            ->join("rol_menu as rm","menu.id","=","rm.id_menu")     
            ->where([
                    ['rm.id_rol','=',session("id_rol")],
                    ['menu.status','Activo'],
                ]
            )
            ->orderby('id_pertenece')
            ->orderby('orden')
            ->orderby('titulo')
            ->get()
            ->toArray();
    }
    public static function menus(){
        $menus = new Menu();
        $data = $menus->optionsMenu();
        $menuAll = [];
        foreach ($data as $line) {
            $item = [ array_merge($line, ['submenu' => $menus->getChildren($data, $line) ]) ];
            $menuAll = array_merge($menuAll, $item);
        }
        return $menus->menuAll = $menuAll;
    }
}

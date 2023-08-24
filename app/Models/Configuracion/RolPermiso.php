<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolPermiso extends Model
{
    use HasFactory;
    public function RolPermisos($id){
        $where=[
            ['rol_permisos.id_rol','=',$id],
        ];
        $permission=RolPermiso::select("p.*")
        ->join("permisos as p","rol_permisos.id_permiso","=","p.id")     
        ->where($where);
        return $permission;
    }
}

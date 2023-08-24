<?php

use App\Models\Configuracion\CfgPagina;
use App\Models\Menu;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

function guardar_archivo($file,$ruta,$fileName=""){
    if (!file_exists($ruta)) {
        mkdir($ruta, 0777, true);
    }
     
    if(empty($fileName)){
        $fileName = time().rand(1,999999); 
    }
    $fileName=$fileName.".".$file->extension();
    $file->move(public_path()."/".$ruta, $fileName);
    $data = $ruta."/".$fileName;
    $resultado = new stdClass();
    $resultado->datas=$data;
    return $resultado;
    //dd(1);   
}

function getAvatar(){
    /*
    if(!empty(Auth::user()->foto)){
        return url('/')."/".Auth::user()->foto;
    }else{
        return  url('/').'/assets/images/user/user.png';
    }
    */
}
function traer_menu(){
    return Menu::menus();
}
//$all = true, $papaId = 0,$arMenuSelected = [],$arrayPermiso=[]
/*
function traer_permisos($data){
    $all=true;
    $papaId=0;
    $arMenuSelected=[];
    $arrayPermiso=[];
    if(!empty($data["all"])){
        $all==$data["all"];
    }
    if(!empty($data["papaId"])){
        $papaId==$data["papaId"];
    }
    if(!empty($data["arMenuSelected"])){
        $arMenuSelected==$data["arMenuSelected"];
    }
    if(!empty($data["arrayPermiso"])){
        $arrayPermiso==$data["arrayPermiso"];
    }

}
function traerPermisosMenu(){

}
*/
function getInfo(){   
    return CfgPagina::select("*",DB::raw("if(logo=null or logo='','/assets/images/logo.png',logo) as logo"))->firstOrFail();
}
function info_usuario(){
    return Auth::user();
}
function getDiffDate($idate,$fdate){
    //use DateTime;
    /*$datetime1 = new \DateTime($idate);
    $datetime2 = new \DateTime($fdate);
    $interval = $datetime1->diff($datetime2);
    $d = $interval->format('%a');
    $m = $interval->format('%m');
    $y = $interval->format('%y');*/
    $startTime = Carbon::parse($idate);
    $endTime = Carbon::parse($fdate);
    $interval =  $startTime->diff($endTime);
    $d = $interval->format('%a');
    $m = $interval->format('%m');
    $y = $interval->format('%y');
    return [
        "d"=>$d,
        "m"=>$m,
        "y"=>$y
    ];
}

function getJerarquiaPermission($all = true, $papaId = 0,$arMenuSelected = [],$arrayPermiso=[]){
    $filtros = [];
    $filtros = [
        ['status', '=', 'Activo']
    ];

    $nodo = '';
    $icono = "icofont icofont-navigation-menu";
    if ($all) {
        $filtros[] = [
            "id_pertenece", 0          
        ];    
    } else {
        array_push($filtros, ['id_pertenece', '=', $papaId]);
    }
    $papaMenu = Menu::with("permisos_menu","hijos")->where($filtros)->get();
    //dd($papaMenu);
    foreach ($papaMenu as $pa) {
        $filtros = [
            //["sucursal_id","=",session("sucursal_id")],
            ['status', '=', 'Activo'],
            ['id_pertenece', '=', $pa->id]
        ];
        $papaMenu = $pa->hijos(); /*Menu::with("permisos_menu","hijos")->where([
            ["asignar",1],
            ["view",1]
        ])->where($filtros)->get();*/

        $color = "dark";
        $icono=$pa->icono;
        $color=$pa->color;
        //$html='';
        if ($papaMenu->count() == 0 and $pa->parent_id > 0) {
            $color = "danger";
            $html='<span class="caret"><i class="f-15 icofont icofont-caret-down"></i></span>';
            //$icono="icofont icofont-hotel-boy";        
        }else if($papaMenu->count() > 0 and $pa->parent_id > 0){
            $color="primary";
            $html='<span class="caret"><i class="f-15 icofont icofont-caret-down"></i></span>';
        }else if($papaMenu->count()>0){
            $html='<span class="caret"><i class="f-15 icofont icofont-caret-down"></i></span>';
        }else{
            $html='<span class="caret"><i class="f-15 icofont icofont-caret-down"></i></span>';
        }
        
      
        if($all){
            $nodo .= '<li class="menu">';
        }else{
            $nodo .= '<ul class="menu">';
        }
        //$selected=0;    
        $selected=''; 
        $checkbox_disabled=0;
        
        /*if(in_array($pa->id, $arMenuSelected) and $pa->permisos_menu->count() > 0 and $pa->parent_id==0){
            //$selected=1;
            $selected='checked';
        }else if(in_array($pa->id, $arMenuSelected) and $pa->permisos_menu->count() == 0 and $pa->hijos->count()==0 and  $pa->parent_id==0){
            //$selected=1;
            $selected='checked';
        }*/
        //$color
        $selected=((in_array($pa->id, $arMenuSelected)) ? 'checked' : '');
        $nodo .= "<li class='activo ' 
        data-jstree='{\"tipo\":0,\"checkbox_disabled\":" . $checkbox_disabled . ",\"selected\":" . $selected . ",\"icon\":\"" . $icono . " text-" . $color . "\",\"type\":\"" . $icono . "\",\"id\":\"" . $pa->id . "\",\"opened\":\"true\"}'>
        $html
        <input type='checkbox' id='".$pa->id."' name='".$pa->id."' class='new-control-input chkmenus' $selected>
        <i class='$icono $color'></i>
       ".$pa->titulo." 
     ";
        $nodo .= getPermisosMenu($pa->permisos_menu, $arrayPermiso,$pa->id);
        //$idSele = 0, $idPapa = 0, $all = true, $papaNew = 0, $relacional = false,
        $nodo .= getJerarquiaPermission(false,$pa->id,$arMenuSelected,$arrayPermiso);
        $nodo .= '</li>';



        if($all){
            $nodo .= '</li>';
        }else{
            $nodo .= '</ul>';
        }
    }
    return $nodo;
}

function getPermisosMenu($permissions, $arrayPermiso,$pertenece)
{
    $nodo="";
    if(!empty($permissions) and $permissions->count()>0){
        $nodo = '<ul class="permiso">';
        $selected='';       
        foreach ($permissions as $key) {
            $selected=((in_array($key->id, $arrayPermiso)) ? 'checked' : '');
            $icono = "icofont icofont-ui-lock";
            $color = "warning";
            $nodo .= "<li class='activo' data-jstree='{\"tipo\":1,\"selected\":" . ((in_array($key->id, $arrayPermiso)) ? 1 : 0) . ",\"icon\":\"" . $icono . " text-" . $color . "\",\"type\":\"" . $icono . "\",\"id\":\"" . $key->id . "\",\"opened\":\"true\"}'>
           
            <input type='checkbox' id='".$key->id."' name='".$key->id."' data-pertenece='$pertenece' class='new-control-input chkpermisos' $selected>
           ".$key->nombre."
        
          </li>";
        }
        $nodo .= '</ul>';
       
    }
    return $nodo;
}

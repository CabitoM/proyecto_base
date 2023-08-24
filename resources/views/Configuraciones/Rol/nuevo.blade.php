@extends("layouts.app-master")
@php 
$titulo="Editar";
if($modulo=="A"){
    $titulo="Alta";
}
@endphp
@push('css')
<style>

   #treePuesto li {
       margin: 0px 0;
      
      list-style-type: none;
       position: relative;
      /*padding: 20px 5px 0px 5px;*/
   }

   #treePuesto ul{
      padding-left: 2.4%;
      margin-bottom: 1rem;
   }
   
   #treePuesto li::before{
       content: '';
      position: absolute; 
       top: 0;
      width: 1px; 
       height: 100%;
      right: auto; 
       left: -20px;
      border-left: 1px solid #ccc;
       bottom: 50px;
   }
   #treePuesto li::after{
       content: '';
      position: absolute; 
       top: 30px; 
      width: 25px; 
       height: 20px;
      right: auto; 
       left: -20px;
      border-top: 1px solid #ccc;
   }
   /*#treePuesto li a{
       display: inline-block;
      border: 1px solid #ccc;
      padding: 5px 10px;
      text-decoration: none;
      color: #666;
      font-family: arial, verdana, tahoma;
      font-size: 11px;
       border-radius: 5px;
      -webkit-border-radius: 5px;
      -moz-border-radius: 5px;
   }*/
   
   /*Remove connectors before root*/
   #treePuesto > ul > li::before, #treePuesto > ul > li::after{
      border: 0;
   }
   /*Remove connectors after last child*/
   #treePuesto li:last-child::before{ 
         height: 30px;
   }
   
   /*Time for some hover effects*/
   /*We will apply the hover effect the the lineage of the element also*/
   /*#treePuesto li a:hover, #treePuesto li a:hover+ul li a {
      background: #c8e4f8; color: #000; border: 1px solid #94a0b4;
   }*/
   /*Connector styles on hover*/
   #treePuesto li a:hover+ul li::after, 
   #treePuesto li a:hover+ul li::before, 
   #treePuesto li a:hover+ul::before, 
   #treePuesto li a:hover+ul ul::before{
      border-color:  #94a0b4;
   }
   
   
   .f-15{
   font-size: 20px !important;
   }
   .oculto {
     display: none;
   }
   
   .activo {
     display: block;
   }
   </style>
@endpush
@section("page_title")
{{$titulo}} Roles
@endsection
@section("content")
<div class="container-fluid">
    <div class="page-header">
       <div class="row">
          <div class="col-lg-6 d-flex flex-column">
              <h3 class="mt-2">{{$titulo}} Roles
             <small>Recuerda llenar la información cuidadosamente</small>
          </h3>
          </div>
          <div class="col-lg-6">
             <ol class="breadcrumb pull-right">
                <li class="breadcrumb-item "><a class="text-danger" href=""><i class="fa fa-home"></i></a></li>
                <li class="breadcrumb-item active">Roles</li>
                <li class="breadcrumb-item active">{{$titulo}}</li>
             </ol>
          </div>
       </div>
    </div>
 </div>

 <div class="container-fluid">
    <form class="" id="frm_rol" autocomplete="off">
       <div class="row">
          <div class="col-sm-12 col-xl-12">
             <div class="card card-absolute">
                <div class="card-header bg-primary">
                   <h5>Datos Generales</h5>
                </div>
                <div class="card-body">
                  <div class="row">
                     <div class="col-lg-12">
                        <div class="form-row">
                           <input type="hidden" id="modulo" name="modulo" value="{{ !empty($modulo)? $modulo : '' }}"> 
                           <input type="hidden" id="id_rol" name="id_rol" value="{{ !empty($rol->id)? ($rol->id): '' }}">
                           <div class="col-md-4 mb-3">
                              <label for="nombre">Nombre*</label>
                              <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Escriba nombre" value="{{ !empty($rol->nombre)? $rol->nombre :'' }}" required>
                           </div>
                           <div class="col-md-4 mb-3">
                              <label for="name_guard">Nombre Interno*</label>
                              <input type="text" class="form-control" id="name_guard" name="name_guard" placeholder="Escriba nombre interno" value="{{ !empty($rol->name_guard)? $rol->name_guard :'' }}" required>
                           </div>
                        </div>
                     </div>
                  </div>
                </div>
             </div>
          </div>
       </div>
       <div class="row">
         <div class="col-sm-12 col-xl-12">
            <div class="card card-absolute">
               <div class="card-header bg-primary">
                  <h5>Permisos Menú</h5>
               </div>
               <div class="card-body">
                  <div class="row">
                     <div class="col-lg-12">
                        @php
                           /*
                        <div id="treecheckbox">
                           
                        </div>
                        */
                        @endphp
                        <div id="treePuesto" style="font-size: 18px;">
                           <ul id="myUL" class="tree">
                                 @php
                                 echo getJerarquiaPermission($all=true,0,$arMenuSelected,$arPermissionSelected);
                                 @endphp
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-sm-12 col-xl-12">
            <div class="card">
               <div class="form-row">
                  <div class="col-sm-12 text-center"> 
                     <button class="btn btn-success btnProceso" type="button" id="btnGuardar">Guardar Información</button>
                     <button class="btn btn-info m-3" id="btnRegresar"  type="button">Regresar a Listado</button>
                  </div>
               </div>
            </div>
         </div>
      </div>
    </form>
 </div>
@endsection
@push("css")
<link rel="stylesheet" type="text/css" href="{{asset("assets/css/tree.css")}}">
@endpush
@push("js")
<script src="{{asset("assets/js/tree/jstree.min.js")}}?>"></script>
<script>
   var urls ={       
        guardar: '{{($modulo=="A")?route("rol/guardar"):route("rol/editar")}}',
        listado: '{{route("rol/listado")}}',
        nuevo: '{{route("rol/nuevo")}}',
        permisos: '{{route("rol/permisos")}}',
   };
</script>
<script src="{{asset("/assets/js/catalogos/roles.js?")}}v=<?=rand(0,9999)?>"></script>
@endpush

    

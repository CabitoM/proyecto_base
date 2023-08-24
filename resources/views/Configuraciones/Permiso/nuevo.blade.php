@extends("layouts.app-master")
@php 
$titulo="Editar";
if($modulo=="A"){
    $titulo="Alta";
}
@endphp
@section("page_title")
{{$titulo}} Permisos
@endsection
@section("content")
<div class="container-fluid">
    <div class="page-header">
       <div class="row">
          <div class="col-lg-6 d-flex flex-column">
              <h3 class="mt-2">{{$titulo}} Permisos
             <small>Recuerda llenar la información cuidadosamente</small>
          </h3>
          </div>
          <div class="col-lg-6">
             <ol class="breadcrumb pull-right">
                <li class="breadcrumb-item "><a class="text-danger" href=""><i class="fa fa-home"></i></a></li>
       
                <li class="breadcrumb-item active">Permisos</li>
                <li class="breadcrumb-item active">{{$titulo}}</li>
             </ol>
          </div>
       </div>
    </div>
 </div>
 <div class="container-fluid">
   <form class="" id="frm_permiso" autocomplete="off">
      <div class="row">
         <div class="col-sm-12 col-xl-12">
            <div class="card card-absolute">
               <div class="card-header bg-primary">
                  <h5>{{$titulo}} Permiso</h5>
               </div>
               <div class="card-body">
                  <div class="row">
                     <input type="hidden" id="modulo" name="modulo" value="{{ !empty($modulo)? $modulo : '' }}"> 
                     <input type="hidden" id="id_permiso" name="id_permiso" value="{{ !empty($permiso->id)? ($permiso->id): '' }}">
                     <div class="col-md-12 form-row mb-3">
                        <div class="col-lg-3">
                           <label for="id_menu">Pertenece a Menú*</label>
                        </div>
                        <div class="col-lg-6 ">
                           <select class="form-control selectpicker" title="seleccione" data-actions-box="true" data-size="5" data-live-search="true" id="id_menu" name="id_menu" required>
                              <option value="0">Ninguno</option>
                              @foreach ($menu as $item)
                              <option {{((!empty($permiso) && $item->id==$permiso->id_menu)?'selected':'')}} value="{{$item->id}}">{{$item->titulo}}</option>
                              @endforeach
                           </select>
                        </div>
                     </div>
                     <div class="col-md-3 mb-3">
                        <label for="name">Nombre*</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Escriba name" value="{{!empty($permiso->nombre)?"$permiso->nombre":""}}" required="" >
                     </div>
                     <div class="col-md-3 mb-3">
                        <label for="name_guard">Nombre Interno*</label>
                        <input type="text" class="form-control" id="name_guard" name="name_guard" placeholder="Escriba nombre interno" value="{{!empty($permiso->name_guard)?"$permiso->name_guard":""}}" required="">
                     </div>
                  </div>
                  <div class="form-row mt-5">
                     <div class="col-sm-12 text-center"> 
                        <button class="btn btn-success" type="button" id="btnGuardar">Guardar Información</button>
                        <button class="btn btn-info" type="button" id="btnRegresar" >Regresar a Listado</button>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </form>
</div>

@endsection
@push("js")
<script src="{{asset("/assets/js/button-builder/colorpicker.js")}}"></script>
<script>
   var urls ={       
        guardar: '{{($modulo=="A")?route("permiso/guardar"):route("permiso/editar")}}',
        listado: '{{route("permiso/listado")}}',
        nuevo: '{{route("permiso/guardar")}}',
   };
</script>
<script src="{{asset("/assets/js/catalogos/permisos.js?")}}v=<?=rand(0,9999)?>"></script>
@endpush
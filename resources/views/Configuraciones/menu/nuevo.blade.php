@extends("layouts.app-master")
@php 
$titulo="Editar";
if($modulo=="A"){
    $titulo="Alta";
}
@endphp
@section("page_title")
{{$titulo}} Menu
@endsection
@section("content")
<div class="container-fluid">
    <div class="page-header">
       <div class="row">
          <div class="col-lg-6 d-flex flex-column">
              <h3 class="mt-2">{{$titulo}} Menu
             <small>Recuerda llenar la información cuidadosamente</small>
          </h3>
          </div>
          <div class="col-lg-6">
             <ol class="breadcrumb pull-right">
                <li class="breadcrumb-item "><a class="text-danger" href=""><i class="fa fa-home"></i></a></li>
       
                <li class="breadcrumb-item active">Menu</li>
                <li class="breadcrumb-item active">{{$titulo}}</li>
             </ol>
          </div>
       </div>
    </div>
 </div>

 <div class="container-fluid">
    <form class="" id="frm_menu" autocomplete="off">
       <div class="row">
          <div class="col-sm-12 col-xl-12">
             <div class="card card-absolute">
                <div class="card-header bg-primary">
                   <h5>{{$titulo}} Menu</h5>
                </div>
                <div class="card-body">
                   <div class="row">
                      <div class="col-lg-12">
                        <div class="form-row">
                           <input type="hidden" id="modulo" name="modulo" value="{{ !empty($modulo)? $modulo : '' }}"> 
                           <input type="hidden" id="id_menu" name="id_menu" value="{{ !empty($menu->id)? ($menu->id): '' }}">  
                           <div class="col-md-3 mb-3">
                               <label for="id_pertenece">Pertenece*</label>
                               <select name="id_pertenece" id="id_pertenece" class="form-control selectpicker" title="seleccione" data-size="4" data-live-search="true" tabindex="-1" aria-hidden="true" required>
                                 <option value="0" {{ (empty($menu->id_pertenece) ) ? 'selected' :'' }} >Ninguno</option>
                                 @forelse ($sel_menus as $item)
                                 <option {{ (!empty($menu->id_pertenece) and $menu->id_pertenece==$item->id) ? 'selected' :'' }} value="{{$item->id}}">{{$item->titulo}}</option>
                                 @empty
                                 @endforelse  
                               </select>
                            </div>
                            <div class="col-md-3 mb-3">
                               <label for="titulo">Titulo*</label>
                               <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Escriba titulo" value="{{ !empty($menu->titulo)? $menu->titulo :'' }}" required="">
                            </div>
                            <div class="col-md-3 mb-3">
                               <label for="orden">Orden*</label>
                               <input type="text" class="form-control" id="orden" name="orden" placeholder="Escriba orden" value="{{ !empty($menu->orden)? $menu->orden :'' }}" required="">
                            </div>
                            <div class="col-md-3 mb-3">
                               <label for="ruta">Ruta*</label>
                               <input type="text" class="form-control" id="ruta" name="ruta" placeholder="Escriba ruta" value="{{ !empty($menu->ruta)? $menu->ruta :'' }}">
                            </div>
                            <div class="col-md-3 mb-3">
                               <label for="icono">Icono*</label>
                               <input type="text" class="form-control" id="icono" name="icono" placeholder="Escriba icono" value="{{ !empty($menu->icono)? $menu->icono :'' }}" required>
                            </div>
                            <div class="col-md-3 mb-3">
                              <label for="color">Color*</label>
                              <select name="color" id="color" class="form-control selectpicker" tabindex="-1" aria-hidden="true">
                                 <option {{ (!empty($menu->color) and $menu->color=="text-info") ? 'selected' :'' }} value="text-info">Azul</option>
                                 <option {{ (!empty($menu->color) and $menu->color=="text-warning") ? 'selected' :'' }} value="text-warning">Amarillo</option>
                                 <option {{ (!empty($menu->color) and $menu->color=="text-danger") ? 'selected' :'' }} value="text-danger">Rojo</option>
                                 <option {{ (!empty($menu->color) and $menu->color=="text-primary") ? 'selected' :'' }} value="text-primary">Azul Cielo</option>
                                 <option {{ (!empty($menu->color) and $menu->color=="text-secondary") ? 'selected' :'' }} value="text-secondary">Gris</option>
                                 <option {{ (!empty($menu->color) and $menu->color=="text-dark") ? 'selected' :'' }} value="text-dark">Negro</option>
                                 <option {{ (!empty($menu->color) and $menu->color=="text-success") ? 'selected' :'' }} value="text-success">Verde</option>
                              </select>
                           </div>
                         </div>
                      </div>
                   </div>
                   <div class="form-row mt-5">
                     <div class="col-sm-12 divCargando" id="divCargando"> </div>
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
        guardar: '{{($modulo=="A")?route("menu/guardar"):route("menu/editar")}}',
        listado: '{{route("menu/listado")}}',
        nuevo: '{{route("menu/guardar")}}',
   };
</script>
<script src="{{asset("/assets/js/catalogos/menu.js?")}}v=<?=rand(0,9999)?>"></script>
@endpush

    

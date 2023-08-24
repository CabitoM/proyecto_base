@extends("layouts.app-master")
@php 
$titulo="Editar";
if($modulo=="A"){
    $titulo="Alta";
}
@endphp
@section("page_title")
{{$titulo}} Sucursales
@endsection
@push("css")
<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/dropzone.css">
@endpush
@section("content")
<div class="container-fluid">
    <div class="page-header">
       <div class="row">
          <div class="col-lg-6 d-flex flex-column">
              <h3 class="mt-2">{{$titulo}} Sucursales
             <small>Recuerda llenar la información cuidadosamente</small>
          </h3>
          </div>
          <div class="col-lg-6">
             <ol class="breadcrumb pull-right">
                <li class="breadcrumb-item "><a class="text-danger" href=""><i class="fa fa-home"></i></a></li>
                <li class="breadcrumb-item active">Sucursal</li>
                <li class="breadcrumb-item active">{{$titulo}}</li>
             </ol>
          </div>
       </div>
    </div>
 </div>

 <div class="container-fluid">
    <form class="" id="frm_sucursal" autocomplete="off">
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
                            <input type="hidden" id="id_sucursal" name="id_sucursal" value="{{ !empty($sucursal->id)? ($sucursal->id): '' }}">
                            <div class="col-md-4 mb-3">
                                <label for="nombre">Nombre*</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Escriba nombre" value="{{ !empty($sucursal->nombre)? $sucursal->nombre :'' }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="nombre_comercial">Nombre Comercial*</label>
                                <input type="text" class="form-control" id="nombre_comercial" name="nombre_comercial" placeholder="Escriba nombre" value="{{ !empty($sucursal->nombre_comercial)? $sucursal->nombre_comercial :'' }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="calle">Calle*</label>
                                <input type="text" class="form-control" id="calle" name="calle" placeholder="Escriba nombre" value="{{ !empty($sucursal->calle)? $sucursal->calle :'' }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="numero">Número*</label>
                                <input type="text" class="form-control" id="numero" name="numero" placeholder="Escriba nombre" value="{{ !empty($sucursal->numero)? $sucursal->numero :'' }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="colonia">Colonia*</label>
                                <input type="text" class="form-control" id="colonia" name="colonia" placeholder="Escriba nombre" value="{{ !empty($sucursal->colonia)? $sucursal->colonia :'' }}" >
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="ciudad">Ciudad*</label>
                                <input type="text" class="form-control" id="ciudad" name="ciudad" placeholder="Escriba nombre" value="{{ !empty($sucursal->ciudad)? $sucursal->ciudad :'' }}" >
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="estado">Estado*</label>
                                <input type="text" class="form-control" id="estado" name="estado" placeholder="Escriba nombre" value="{{ !empty($sucursal->estado)? $sucursal->estado :'' }}" >
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="cp">Código Postal*</label>
                                <input type="text" class="form-control" id="cp" name="cp" placeholder="Escriba nombre" value="{{ !empty($sucursal->cp)? $sucursal->cp :'' }}" >
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="correo">Correo*</label>
                                <input type="text" class="form-control correo" id="correo" name="correo" placeholder="Escriba nombre" value="{{ !empty($sucursal->correo)? $sucursal->correo :'' }}" >
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="telefono">Teléfono*</label>
                                <input type="text" class="form-control telefono" id="telefono" name="telefono" placeholder="(666) 666-6666" value="{{ !empty($sucursal->telefono)? $sucursal->telefono :'' }}" >
                            </div>
                         </div>
                         <div class="form-row">
                            <div class="col-lg-4">
                                <label for="files">Logotipo*</label>
                                <div class="dropzone dropzone-primary" id="fileUpload">
                                   <div class="fallback">
                                      <input id="files" multiple="true" name="files[]" type="file">
                                   </div>
                                   <div class="dz-message needsclick">
                                      <i class="icon-cloud-up"></i>
                                      <h6>Arrastre los archivos aquí o haga clic para cargar.</h6>
                                   </div>
                                </div>
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
<script src="{{url('/')}}/assets/js/dropzone/dropzone.js" ></script>
<script>
   var urls ={       
        guardar: '{{($modulo=="A")?route("sucursal/guardar"):route("sucursal/editar")}}',
        listado: '{{route("sucursal/index")}}',
        nuevo: '{{route("sucursal/nueva")}}',
        getImage:'{{route("sucursal/getImageDropzone")}}',
        removeImage:'{{route("sucursal/deleteImageDropzone")}}',
   };
   Dropzone.autoDiscover = false;
   $(function () {   
      var formData=new FormData();
      formData.append("id",$("#id_sucursal").val());
      iniciarDropzone({
        idDropzone: "fileUpload",
        urlFake: "guardar.php",
        idInputFile: "files",
        archivosPermitidos: "image/*,application/pdf",
        urlObtener:urls.getImage,
        formData:formData,
        dataObtenerArchivos: {/*
          disk: "public",
          ruta:'users/avatar/{{Auth::user()->id}}/{{Auth::user()->foto}}' ,
          name:'avatar' */       
        },
        modulo: "M",
        urlEliminar: urls.removeImage,
      });
    
   });  
</script>
<script src="{{asset("/assets/js/catalogos/sucursales.js?")}}v=<?=rand(0,9999)?>"></script>
@endpush

    

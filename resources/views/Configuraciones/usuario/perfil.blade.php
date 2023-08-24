@extends("layouts.app-master")
@php
$titulo="Perfil";
@endphp
@section("page_title")
{{$titulo}} Usuarios
@endsection
@section("content")
<div class="container-fluid">
    <div class="page-header">
       <div class="row">
          <div class="col-lg-6 d-flex flex-column">
              <h3 class="mt-2">{{$titulo}}
             <small>Recuerda llenar la información cuidadosamente</small>
          </h3>
          </div>
          <div class="col-lg-6">
             <ol class="breadcrumb pull-right">
                <li class="breadcrumb-item "><a class="text-danger" href=""><i class="fa fa-home"></i></a></li>

                <li class="breadcrumb-item active">Usuarios</li>
                <li class="breadcrumb-item active">{{$titulo}}</li>
             </ol>
          </div>
       </div>
    </div>
 </div>

 <div class="container-fluid">
    <form class="" id="frm_usuario" autocomplete="off">
       <div class="row">
          <div class="col-sm-12 col-xl-12">
             <div class="card card-absolute">
                <div class="card-header bg-primary">
                   <h5>Perfil</h5>
                </div>
                <div class="card-body">
                   <div class="row">
                      <div class="col-lg-8">
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                               <label for="name">Nombre*</label>
                               <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Escriba nombre" value="{{ !empty($usuario->name)? $usuario->name :'' }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                               <label for="username">Usuario*</label>
                               <input type="text" autocomplete="off" class="form-control" id="username" name="username" placeholder="Escriba username" value="{{ !empty($usuario->username)? $usuario->username :'' }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                               <label for="email">Correo electrónico</label>
                               <input type="email" class="form-control" id="correo" name="correo" placeholder="Escriba Correo electrónico" value="{{ !empty($usuario->email)? $usuario->email: '' }}" autocomplete="off" >
                            </div>
                            <div class="col-md-4 mb-3">
                               <label for="telefono">Teléfono*</label>
                               <input type="text" class="telefono form-control" id="telefono" name="telefono" placeholder="Escriba telefono" value="{{ !empty($usuario->telefono)? $usuario->telefono :'' }}">
                            </div>
                            <div class="col-md-4 mb-3">
                               <label for="direccion">Dirección*</label>
                               <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Escriba direccion" value="{{ !empty($usuario->direccion)? $usuario->direccion :'' }}" >
                            </div>
                            <div class="col-md-12"></div>
                            <div class="col-md-4 mb-3 ">
                               <label for="password">Contraseña de Acceso*</label>
                               <div class="input-group">
                                 <input type="password" class="form-control" id="password" name="password" placeholder="Escriba Contraseña" autocomplete="new-password" >
                                 <div class="input-group-append">
                                    <span class="input-group-text fa fa-eye"id="btn_pass"></span>
                                </div>
                               </div>
                            </div>
                            <div class="col-md-4 mb-3">
                              <label for="repetir_password">Repetir Contraseña de Acceso*</label>
                              <div class="input-group">
                                 <input type="password" autocomplete="new-password"  class="form-control" id="repetir_password" name="repetir_password" placeholder="Escriba repita Contraseña" >
                                 <div class="input-group-append">
                                    <span class="input-group-text fa fa-eye" id="btn_pass2"></span>
                                 </div>
                              </div>

                            </div>
                         </div>
                      </div>
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
                      <div class="col-lg-12">
                        <div class="form-row mt-5">
                           <div class="col-sm-12 divCargando" id="divCargando"> </div>
                           <div class="col-sm-12 text-center">
                              <button class="btn btn-success" type="button" id="btnGuardar">Guardar Información</button>
                           </div>
                        </div>
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
    guardar: '',
    getImage:'{{route("sucursal/getImageDropzone")}}',
    removeImage:'{{route("sucursal/deleteImageDropzone")}}',
};
Dropzone.autoDiscover = false;
$(function () {
    var formData=new FormData();
    formData.append("id",1);
    iniciarDropzone({
    idDropzone: "fileUpload",
    urlFake: "guardar.php",
    idInputFile: "files",
    archivosPermitidos: "image/*",
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
<script src="{{asset("/assets/js/catalogos/perfil.js?")}}v=<?=rand(0,9999)?>"></script>
@endpush



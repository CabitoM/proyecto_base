@extends("layouts.app-master")
@php
$titulo="Editar";
if($modulo=="A"){
    $titulo="Alta";
}
@endphp
@section("page_title")
{{$titulo}} Usuarios
@endsection
@section("content")
<div class="container-fluid">
    <div class="page-header">
       <div class="row">
          <div class="col-lg-6 d-flex flex-column">
              <h3 class="mt-2">{{$titulo}} Usuarios
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
                   <h5>{{$titulo}} Usuarios</h5>
                </div>
                <div class="card-body">
                   <div class="row">
                      <div class="col-lg-12">
                        <div class="form-row">
                           <input type="hidden" id="modulo" name="modulo" value="{{ !empty($modulo)? $modulo : '' }}">
                           <input type="hidden" id="id_user" name="id_user" value="{{ !empty($usuario->id)? ($usuario->id): '' }}">
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
                                 <input type="password" class="form-control" id="password" name="password" placeholder="Escriba Contraseña" autocomplete="new-password"  {{ ($modulo=="A") ? 'required' : '' }}>
                                 <div class="input-group-append">
                                    <span class="input-group-text fa fa-eye"id="btn_pass"></span>
                                </div>
                               </div>
                            </div>
                            <div class="col-md-4 mb-3">
                              <label for="repetir_password">Repetir Contraseña de Acceso*</label>
                              <div class="input-group">
                                 <input type="password" autocomplete="new-password"  class="form-control" id="repetir_password" name="repetir_password" placeholder="Escriba repita Contraseña"  {{ ($modulo=="A") ? 'required' : '' }}>
                                 <div class="input-group-append">
                                    <span class="input-group-text fa fa-eye" id="btn_pass2"></span>
                                 </div>
                              </div>

                            </div>
                         </div>
                      </div>
                   </div>
                </div>
             </div>

             <div class="card card-absolute">
               <div class="card-header bg-primary">
                  <h5>Accesos</h5>
               </div>
               <div class="card-body">
                  <div class="row">
                     <div class="col-lg-12 col-md-12">
                        <ul class="nav nav-tabs border-tab nav-info" id="top-tab" role="tablist">
                           @php $c=1; @endphp
                           @forelse ($plazas as $p)
                           <li class="nav-item">
                              <a class="nav-link {{($c==1)?'active':''}}" id="{{$p->id}}-plaza-tab" data-toggle="tab" href="#{{$p->id}}-plaza" role="tab" aria-controls="{{$p->id}}-plaza" aria-selected="{{($c==1)?'true':'false'}}">
                              <i class="icofont icofont-ui-home"></i>{{$p->name}}</a>
                           </li>
                           @php $c++; @endphp
                           @empty
                           @endforelse
                        </ul>
                        <div class="tab-content" id="v-pills-success-tabContent">
                           @php $c=1; @endphp
                           @forelse ($plazas as $p)
                           <div class="tab-pane fade {{($c==1)?'active show':''}}" id="{{$p->id}}-plaza" role="tabpanel" aria-labelledby="{{$p->id}}-plaza-tab">
                              <table class="table table-bordered table-striped">
                                 <thead>
                                    <tr>
                                       <th>Sucursal</th>
                                       <th>Perfil</th>
                                       <th>Acceso</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    @forelse ($p->sucursales as $s)
                                    <tr>
                                       <td>{{$s->nombre}}</td>
                                       <td class="select2-drpdwn">
                                          <select class=" selectpicker form-control perfil_sucursal" title="Seleccione" id="{{$s->id}}_id_rol" name="{{$s->id}}_id_rol" >
                                             <option  value="0" selected>Ninguno</option>
                                             @forelse ($roles as $rol)
                                             <option {{(!empty($arrayRoleUser) and in_array($s->id."-".$rol->id,$arrayRoleUser["perfil"]))?'selected':''}} value="{{$rol->id}}">{{$rol->nombre}}</option>
                                             @empty
                                             @endforelse
                                          </select>
                                       </td>
                                       <td class="w-50 digitos">
                                          <div class="media-body icon-state switch-outline">
                                             <label class="switch">
                                             <input class="chk" type="checkbox" id="{{$s->id}}-chk-acceso" name="{{$s->id}}-chk-acceso" {{(!empty($arrayRoleUser) and in_array($s->id."-Y",$arrayRoleUser["chk"]))?'checked':''}}>
                                             <span class="switch-state bg-success"></span>
                                             </label>
                                          </div>
                                       </td>
                                    </tr>
                                    @empty
                                    @endforelse
                                 </tbody>
                              </table>
                           </div>
                           @php $c++; @endphp
                           @empty
                           @endforelse
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
<script>
   var urls ={
        guardar: '{{($modulo=="A")?route("usuario/guardar"):route("usuario/editar")}}',
        listado: '{{route("usuario/index")}}',
        nuevo: '{{route("usuario/create")}}',
   };
</script>
<script src="{{asset("/assets/js/catalogos/usuarios.js?")}}v=<?=rand(0,9999)?>"></script>
@endpush



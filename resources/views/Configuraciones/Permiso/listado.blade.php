@extends("layouts.app-master")
@php
    $titulo="Listado Permisos";
@endphp
@section("page_title")
{{$titulo}}
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
       
                <li class="breadcrumb-item active">Permisos</li>
                <li class="breadcrumb-item active">Listado</li>
             </ol>
          </div>
       </div>
    </div>
 </div>
 <div class="container-fluid">
    <form class="needs-validation" id="FrmValidate" autocomplete="off">
       <div class="row">
          <div class="col-sm-12 col-xl-12">
             <div class="card card-absolute">
                <div class="card-header bg-primary">
                   <h5>Listado de Permisos</h5>
                </div>
                <div class="card-body">
                   <div class="row">
                      <div class="col-lg-12">
                         <button type="button" id="btnNew" name="btnNew" class="btn btn-info m-3"><i class="icon-save"></i> Nuevo</button>
                         <div class="table-responsive">
                            <table id="table_permisos" class="table-bordered  table-hover" style="text-align: center;">
                               <thead>
                                  <tr>
                                     <th>#</th>
                                     <th>NOMBRE</th>
                                     <th>NOMBRE INTERNO</th>
                                     <th>MENU</th>  
                                     <th>USUARIO ALTA</th> 
                                     <th>OPCIONES</th>
                                  </tr>
                               </thead>
                               <tbody>
                                  @php $c=0; @endphp
                                  @forelse($data as $permiso)
                                  @php $c++; @endphp
                                  <tr id="tr-{{$permiso->id}}">
                                     <td>{{$c}}</td>
                                     <td>{{$permiso->nombre}}</td>   
                                     <td>{{$permiso->name_guard}}</td>  
                                     <td>{{$permiso->menu}}</td>  
                                     <td>{{$permiso->usuario_alta}}</td>
                                     <td>                                             
                                       <div class="btn-group">
                                          <a href=""  id="btn_ver" name="btn_ver"  class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>
                                          <a href="{{ route('permiso/ver',['id'=>($permiso->id)]) }}" class="btn btn-sm btn-warning edit"><i class="fa fa-pencil"></i></a>
                                          <a href="javascript:eliminar_reg({{$permiso->id}})"  id="btnDelete_{{$permiso->id}}" name="btnDelete_{{$permiso->id}}"  class="btn btn-sm  btn-danger"><i class="fa fa-trash-o"></i></a> 
                                       </div>                                     
                                     </td>
                                  </tr>
                                  @empty
                                  
                                  @endforelse
                               </tbody>
                            </table>
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
<script>
   var urls ={       
        nuevo: '{{route("permiso/nuevo")}}',
        eliminar:'{{route("permiso/eliminar")}}',
   };
</script>
<script src="{{asset("/assets/js/catalogos/permisos.js?")}}v=<?=rand(0,9999)?>"></script>
@endpush
@extends("layouts.app-master")
@section("page_title")
Listado Sucursal
@endsection
@section("content")
<div class="container-fluid">
    <div class="page-header">
       <div class="row">
          <div class="col-lg-6 d-flex flex-column">
              <h3 class="mt-2">Listado de Sucursales
             <small>Recuerda llenar la información cuidadosamente</small>
          </h3>
          </div>
          <div class="col-lg-6">
             <ol class="breadcrumb pull-right">
                <li class="breadcrumb-item "><a class="text-danger" href=""><i class="fa fa-home"></i></a></li>
       
                <li class="breadcrumb-item active">Sucursales</li>
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
                   <h5>Listado de Sucursales</h5>
                </div>
                <div class="card-body">
                   <div class="row">
                      <div class="col-lg-12">
                         <button type="button" id="btnNew" name="btnNew" class="btn btn-info m-3"><i class="icon-save"></i> Nueva Sucursal</button>
                         <div class="table-responsive">
                            <table id="tbl-products" class="table table-bordered  table-hover" style="text-align: center;">
                               <thead>
                                  <tr>
                                     <th>#</th>
                                     <th>Nombre</th>  
                                     <th>Usuario Alta</th> 
                                     <th>Teléfono</th>
                                     <th>OPCIONES</th>
                                  </tr>
                               </thead>
                               <tbody>
                                  @php $c=0; @endphp
                                  @forelse($data as $s)
                                  @php $c++; @endphp
                                  <tr id="tr-{{$s->id}}">
                                     <td>{{$c}}</td>
                                     <td>{{$s->nombre}}</td>   
                                     <td>{{$s->usuario_alta}}</td>  
                                     <td>{{$s->telefono}}</td>
                                     <td>                                             
                                       <div class="btn-group">
                                          <a href=""  id="btn_ver" name="btn_ver"  class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>
                                          <a href="{{ route('sucursal/ver',['id'=>($s->id)]) }}" class="btn btn-sm btn-warning edit"><i class="fa fa-pencil"></i></a>
                                          <a href="javascript:eliminar_reg({{$s->id}})"  id="btnDelete_{{$s->id}}" name="btnDelete_{{$s->id}}"  class="btn btn-sm  btn-danger"><i class="fa fa-trash-o"></i></a> 
                                       </div>                                     
                                     </td>
                                  </tr>
                                  @empty
                                  @endforelse
                               </tbody>
                            </table>
                         </div>
                      </div>
                      <div class="col-sm-12 divCargando" id="divCargando"> </div>
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
        nuevo: '{{route("sucursal/nueva")}}',
        eliminar:'{{route("sucursal/eliminar")}}',
   };
</script>
<script src="{{asset("/assets/js/catalogos/sucursales.js?")}}v=<?=rand(0,9999)?>"></script>
@endpush

    

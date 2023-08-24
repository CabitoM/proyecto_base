@extends("layouts.app-master")
@section("page_title")
Listado Menu
@endsection
@section("content")
<div class="container-fluid">
    <div class="page-header">
       <div class="row">
          <div class="col-lg-6 d-flex flex-column">
              <h3 class="mt-2">Listado de Menu
             <small>Recuerda llenar la información cuidadosamente</small>
          </h3>
          </div>
          <div class="col-lg-6">
             <ol class="breadcrumb pull-right">
                <li class="breadcrumb-item "><a class="text-danger" href=""><i class="fa fa-home"></i></a></li>
       
                <li class="breadcrumb-item active">Menu</li>
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
                   <h5>Listado de Menu</h5>
                </div>
                <div class="card-body">
                   <div class="row">
                      <div class="col-lg-12">
                         <button type="button" id="btnNew" name="btnNew" class="btn btn-info m-3"><i class="icon-save"></i> Nuevo</button>
                         <div class="table-responsive">
                            <table id="table_menu" class="table-bordered  table-hover" style="text-align: center;">
                               <thead>
                                  <tr>
                                     <th>#</th>
                                     <th>TITULO</th>
                                     <th>RUTA</th>
                                     <th>PERTENECE</th>  
                                     <th>ICONO</th>  
                                     <th>Usuario Alta</th> 
                                     <th>OPCIONES</th>
                                  </tr>
                               </thead>
                               <tbody>
                                  @php $c=0; @endphp
                                  @forelse($data as $m)
                                  @php $c++; @endphp
                                  <tr id="tr-{{$m->id}}">
                                     <td>{{$c}}</td>
                                     <td>{{$m->titulo}}</td>   
                                     <td>{{$m->ruta}}</td>  
                                     <td>{{$m->pertenece}}</td>  
                                     <td><i class="{{$m->icono}}"></i>{{$m->icono}}</td>  
                                     <td>{{$m->usuario_alta}}</td> 
                                     <td>                                             
                                       <div class="btn-group">
                                          <a href=""  id="btn_ver" name="btn_ver"  class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>
                                          <a href="{{ route('menu/ver',['id'=>($m->id)]) }}" class="btn btn-sm btn-warning edit"><i class="fa fa-pencil"></i></a>
                                          <a href="javascript:eliminar_reg({{$m->id}})"  id="btnDelete_{{$m->id}}" name="btnDelete_{{$m->id}}"  class="btn btn-sm  btn-danger"><i class="fa fa-trash-o"></i></a> 
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
        nuevo: '{{route("menu/nuevo")}}',
        eliminar:'{{route("menu/eliminar")}}',
   };
</script>
<script src="{{asset("/assets/js/catalogos/menu.js?")}}v=<?=rand(0,9999)?>"></script>
@endpush

    

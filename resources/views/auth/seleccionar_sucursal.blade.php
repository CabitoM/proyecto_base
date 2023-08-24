@extends("layouts.auth-master")
@section("page_title")
<title>Iniciar  Sesión</title>
@endsection
@section("auth_header")
<h6>Selecciona Sucursal</h6>
@endsection
@section("auth_form")
    <form action="{{route('elegir_sucursal')}}" method="POST">
        @csrf
        <div class="form-group">
            <select class="form-control" name="sucursal" id="sucursal">
               @forelse ($sucursales as $s)
               <option value="{{$s->id}}">{{$s->sucursal}}</option>
               @empty
               @endforelse
            </select>
         </div>
        @include("layouts.mensajes_errores")
        <div class="form-group form-row mt-3 mb-0">
            <div class="col-md-3">
                <button type="submit" class="btn btn-secondary">Ingresar</button>
            </div>
        </div>
    </form>
@endsection
    

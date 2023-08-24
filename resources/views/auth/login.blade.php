@extends("layouts.auth-master")
@section("page_title")
<title>Iniciar  Sesión</title>
@endsection
@section("auth_header")
<h4>Iniciar Sesión</h4>
<h6>Ingresa tu Usuario/Correo y Contraseña Para Ingresar</h6>
@endsection
@section("auth_form")
    <form action="{{route('login')}}" method="POST">
        @csrf
        <div class="form-group">
            <label class="col-form-label pt-0">usuario/email:</label>
            <input type="text" name="username" id="" class="form-control" required="">
        </div>
        <div class="form-group">
            <label class="col-form-label pt-0">Cotraseña:</label>
            <input type="password" name="password" id="" class="form-control" required="">
        </div>
        <div class="checkbox p-0">
            <input id="recordarme" name="recordarme" type="checkbox">
            <label for="recordarme">Recordarme</label>
        </div>
        @include("layouts.mensajes_errores")
        <div class="form-group form-row mt-3 mb-0">
            <div class="col-md-3">
                <button type="submit" class="btn btn-secondary">Ingresar</button>
            </div>
        </div>
    </form>
@endsection
    

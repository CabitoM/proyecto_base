@extends("layouts.auth-master")
@section("page_title")
<title>Registro</title>
@endsection
@section("auth_header")
<h4>Registro de usuario</h4>
<h6>Rellena todos los campos</h6>
@endsection
@section("auth_form")
    <form action="{{route('register')}}" method="POST">
        @csrf
        <div class="form-group">
            <label class="col-form-label pt-0">usuario</label>
            <input type="text" name="username" class="form-control" required="">
        </div>
        <div class="form-group">
            <label class="col-form-label pt-0">email</label>
            <input type="email" name="email" class="form-control" required="">
        </div>
        <div class="form-group">
            <label class="col-form-label pt-0">password</label>
            <input type="password" name="password" class="form-control" required="">
        </div>
        <div class="form-group">
            <label class="col-form-label pt-0">password</label>
            <input type="password" name="password_confirmation" class="form-control" required="">
        </div>
        @include("layouts.mensajes_errores")
        <div class="form-group form-row mt-3 mb-0">
            <div class="col-md-3">
                <button type="submit" class="btn btn-secondary">Registrar</button>
            </div>
        </div>
    </form>
@endsection
@extends("layouts.app-master")
@section("page_title")
Inicio Usuarios
@endsection
@section("content")
    <h1>Home</h1>
    @auth
        <p>Estas Autenticado, Bienvenido {{auth()->user()->name ?? auth()->user()->username}}</p>
        <p>Sucursal {{session('sucursal')}}</p>
        <p>Rol {{session("rol")}}</p>
        <p><a href="{{route('logout')}}">Cerrar sesion</a></p>

    @endauth
    @guest
        <p><a href="{{route('login')}}">Inicia sesion </a></p>
    @endguest
@endsection
    

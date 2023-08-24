@extends('errors::illustrated-layout')

@section('title', __('¡UPS! Parece que estas buscando una página que no existe'))
@section('code')
<h2 class="headline font-danger">404</h2>
@endsection
@section('message', __('No se encontró lo que buscabas'))

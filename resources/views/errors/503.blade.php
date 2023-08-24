@extends('errors::illustrated-layout')

@section('title', __('Servicio no disponible'))
@section('code')
<h2 class="headline font-primary">503</h2>
@endsection
@section('message', __($exception->getMessage() ?: 'Servicio no disponible'))

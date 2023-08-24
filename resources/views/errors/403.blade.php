@extends('errors::illustrated-layout')

@section('title', __('Acceso Prohibido'))
@section('code')
<h2 class="headline font-success">403</h2>
@endsection
@section('message', __($exception->getMessage() ?: 'Acceso Prohibido'))

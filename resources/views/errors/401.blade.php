@extends('errors::illustrated-layout')

@section('title', __('No Tienes Autorización'))
@section('code')
<h2 class="headline font-danger">404</h2>
@endsection
@section('message', $exception->getMessage())

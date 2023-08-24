<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" type="image/png" sizes="16x16"  href="{{asset("assets/images/favicon.png")}}">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="theme-color" content="#ffffff">
<title>@yield('page_title','Dsoft system')</title>
<!--Google font-->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700" rel="stylesheet">
<!-- Font Awesome -->
<link rel="stylesheet" type="text/css" href="{{asset("assets/css/fontawesome.css")}}">
<!-- ico-font -->
<link rel="stylesheet" type="text/css" href="{{asset("/assets/css/icofont.css")}}">
<!-- Themify icon -->
<link rel="stylesheet" type="text/css" href="{{asset("/assets/css/themify.css")}}">
<!-- Flag icon -->
<link rel="stylesheet" type="text/css" href="{{asset("/assets/css/flag-icon.css")}}">
<link rel="stylesheet" type="text/css" href="{{asset("/assets/css/tree.css")}}">
<!-- Bootstrap css -->
<link rel="stylesheet" type="text/css" href="{{asset("/assets/css/datatables.css")}}" />
<link rel="stylesheet" type="text/css" href="{{asset("/assets/css/datatable-extension.css")}}">
<?php /* <link rel="stylesheet" type="text/css" href="{{asset("")}}/assets/css/select2.css" />*/?>
<link rel="stylesheet" type="text/css" href="{{asset("/assets/js/bootstrap-selectpicker/bootstrap-select.css")}}" />
<link rel="stylesheet" type="text/css" href="{{asset("/assets/css/date-time-picker.css")}}">
<link rel="stylesheet" type="text/css" href="{{asset("/assets/css/bootstrap.css")}}">
<!-- App css -->

@if ($info->vertical=="Y")
<link  rel="stylesheet" type="text/css"  href="{{asset("/assets/css/vertical-menu.css")}}">
@endif

<link rel="stylesheet" type="text/css" href="{{asset("/assets/css/style.css")}}?v=@php echo rand(0,9999); @endphp">
<link rel="stylesheet" type="text/css" href="{{asset("/assets/css/dropzone.css")}}">
<!-- Responsive css -->
<link rel="stylesheet" type="text/css" href="{{asset("/assets/css/responsive.css")}}">
@stack('css')

<style>
.label{
	font-weight: bold;
}
.error{
	margin-top: 2px;
	margin-bottom: 0;
	color: #dc3545 !important;
}
.form_control_valid:focus{
	border-color: #dc3545;
	-webkit-box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
	box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}
.form_control_invalid:focus{
	border-color: #28a745;
	-webkit-box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
	box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
}
.input-group > .form-control:not(:first-child), .input-group > .custom-select:not(:first-child) {
	border-radius: 0.25rem !important;
}
</style>

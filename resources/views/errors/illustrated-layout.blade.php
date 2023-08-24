<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{url('/')}}/assets/images/favicon.png" type="image/x-icon" />
    <link rel="shortcut icon" href="{{url('/')}}/assets/images/favicon.png" type="image/x-icon" />
    <title>@yield('title')</title>

    <!--Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="{{asset("/assets/css/fontawesome.css")}}">

    <!-- ico-font -->
    <link rel="stylesheet" type="text/css" href="{{asset("/assets/css/icofont.css")}}">

    <!-- Themify icon -->
    <link rel="stylesheet" type="text/css" href="{{asset("/assets/css/themify.css")}}">

    <!-- Flag icon -->
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/css/flag-icon.css')}}">

    <!-- Bootstrap css -->
    <link rel="stylesheet" type="text/css" href="{{asset("/assets/css/bootstrap.css")}}">

    <!-- App css -->
    <link rel="stylesheet" type="text/css" href="{{asset("/assets/css/style.css")}}">

    <!-- Responsive css -->
    <link rel="stylesheet" type="text/css" href="{{asset("/assets/css/responsive.css")}}">

</head>

<body>

<!-- Loader starts -->
<div class="loader-wrapper">
    <div class="loader bg-white">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
        <h4>Cargando... <span>&#x263A;</span></h4>
    </div>
</div>
<!-- Loader ends -->

<!--page-wrapper Start-->
<div class="page-wrapper">
    <!--error-400 start-->
    <div class="error-wrapper">
        <div class="container">
            <img src="{{asset("/assets/images/sad.png")}}" class="img-100" alt="">
            <div class="error-heading">
                <img src="{{asset("/assets/images/cloud-bg-1.png")}}" class="cloud-first" alt="">
               @yield('code', __('<h2 class="headline font-dark">ERROR DESCONOCIDO</h2>'))
                <img src="{{asset("/assets/images/cloud-bg-2.png")}}" class="cloud-second" alt="">
            </div>
            <div class="col-md-8 offset-md-2">
                <p class="sub-content">@yield('title')</p>
                <p>@yield('message')</p>
            </div>
            <div class="">
                <a href="{{route('home.index') }}" class="btn btn-dark-gradien btn-lg">Regresar a Inicio</a>
            </div>
        </div>
    </div>
    <!--error-400 end-->
</div>
<!--page-wrapper Ends-->

<!-- latest jquery-->
<script src="{{asset("/assets/js/jquery-3.2.1.min.js")}}"></script>

<!-- Bootstrap js-->
<script src="{{asset("/assets/js/bootstrap/popper.min.js")}}"></script>
<script src="{{asset("/assets/js/bootstrap/bootstrap.js")}}"></script>

<!-- Theme js-->
<script src="{{asset("/assets/js/script.js")}}"></script>

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @yield("page_title")
    @include('layouts.plugins_css')
</head>
<body>
    <div class="page-wrapper">
        <div class="container-fluid">
            <!--login page start-->
            <div class="authentication-main">
                <div class="row">
                    <div class="col-md-4 p-0">
                        <div class="auth-innerleft">
                            <div class="text-center">
                                <img src="assets/images/logo-login.png" class="logo-login" alt="">
                                <hr>
                                <div class="social-media">
                                    <ul class="list-inline">
                                        <li class="list-inline-item"><i class="fa fa-facebook txt-fb" aria-hidden="true"></i></li>
                                        <li class="list-inline-item"><i class="fa fa-google-plus txt-google-plus" aria-hidden="true"></i></li>
                                        <li class="list-inline-item"><i class="fa fa-twitter txt-twitter" aria-hidden="true"></i></li>
                                        <li class="list-inline-item"><i class="fa fa-linkedin txt-linkedin" aria-hidden="true"></i></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 p-0">
                        <div class="auth-innerright">
                            <div class="authentication-box">
                                @yield('auth_header')
                                <div class="card mt-4 p-4 mb-0">
                                    @yield("auth_form")
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--login page end-->
        </div>
    </div>
    @include('layouts.plugins_js')
</body>
</html>

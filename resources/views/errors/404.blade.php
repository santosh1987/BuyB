<!-- @extends('errors::minimal')
@section('title', __('Not Found'))
@section('code', '404')
@section('message', __('Not Found')) -->

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>@section('title', __('Not Found'))</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('public/Admin//images/favicon.ico')}}">
        <!-- App css -->
        <link href="{{ asset('public/Admin/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('public/Admin/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('public/Admin/css/app.min.css')}}" rel="stylesheet" type="text/css" />

    </head>

    <body class="authentication-bg">

        <div class="mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12">

                        <div class="text-center">
                            <h2>
                                <a href="index.html">
                                    <img src="{{asset('public/Admin/images/logo-dark.png')}}" alt="main-logo" height="28" />
                                </a>
                            </h2>

                            <img src="{{asset('public/Admin/images/maker-launch.svg')}}" width="180" class="mt-4" alt="error-image"/>

                            <h3>404, Not Found</h3>

                            
                        </div> <!-- end /.text-center-->

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->

        <footer class="footer footer-alt">
            2021 &copy; BuyBombay 
        </footer>


        <!-- Vendor js -->
        <script src="{{asset('public/Admin/js/vendor.min.js')}}"></script>

        <!-- Plugins js-->
        <script src="{{asset('public/Admin/libs/jquery-countdown/jquery.countdown.min.js')}}"></script>

        <!-- Countdown js -->
        <script src="{{asset('public/Admin/js/pages/coming-soon.init.js')}}"></script>

        <!-- App js -->
        <script src="{{asset('public/Admin/js/app.min.js')}}"></script>
        
    </body>
</html>
<script>
    setTimeout(function() {
        // alert("404 Error");
        location.href="{{url('dashboard')}}";
    }, 2000);
    
    </script>
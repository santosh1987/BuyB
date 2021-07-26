<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>BuyBombay | Change Password </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="buybombay" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{asset('public/Admin/images/logo-sm.png')}}">

        <!-- App css -->
        <link href="{{ asset('public/Admin/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('public/Admin/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('public/Admin/css/app.min.css')}}" rel="stylesheet" type="text/css" />

    </head>

    <body class="authentication-bg authentication-bg-pattern">

        <div class="account-pages mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card">

                            <div class="card-body p-4">
                                
                                <div class="text-center w-75 m-auto">
                                    <a href="index.html">
                                        <span><img src="{{ asset('public/Admin/images/logo.png')}}" alt="" height="50"></span>
                                    </a>
                                    <p class="text-muted mb-4 mt-3">Enter your email address and password to access your account.</p>
                                </div>

                               
                               
                                <form action="{{ url('changePassword') }}" method="post">
                                   

                                    <div class="form-group mb-3">
                                        <label for="password">Password</label>
                                        <input class="form-control" type="password" name="password" required="" id="password" autocomplete="New-password">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="text">Confirm Password</label>
                                        <input class="form-control" type="password" name="confirmPassword" required="" id="confirmPassword" autocomplete="Confirm-password">
                                    </div>                                   

                                    <div class="form-group mb-0 text-center">
                                        <button class="btn btn-danger btn-block" type="submit">Change </button>
                                    </div>

                                </form>

                                <!-- <div class="text-center">
                                    <h5 class="mt-3 text-muted">Sign in with</h5>
                                    <ul class="social-list list-inline mt-3 mb-0">
                                        <li class="list-inline-item">
                                            <a href="javascript: void(0);" class="social-list-item border-primary text-primary"><i class="mdi mdi-facebook"></i></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript: void(0);" class="social-list-item border-danger text-danger"><i class="mdi mdi-google"></i></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript: void(0);" class="social-list-item border-info text-info"><i class="mdi mdi-twitter"></i></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript: void(0);" class="social-list-item border-secondary text-secondary"><i class="mdi mdi-github-circle"></i></a>
                                        </li>
                                    </ul>
                                </div> -->

                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->                        
                        <!-- end row -->

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->


        <footer class="footer footer-alt">
            <div style="margin-top:-50px;">2021 &copy; BuyBombay </div>
        </footer>

        <!-- Vendor js -->
        <script src="{{ asset('public/Admin/js/vendor.min.js')}}"></script>

        <!-- App js -->
        <script src="{{ asset('public/Admin/js/app.min.js')}}"></script>
        
    </body>
</html>
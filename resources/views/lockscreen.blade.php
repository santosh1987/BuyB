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

                                <div class="text-center mb-4">
                                    <a href="index.html">
                                        <span><img src="{{asset('public/Admin/images/logo.png')}}" alt="" height="26"></span>
                                    </a>
                                </div>                                
                                <div class="text-center w-75 m-auto">
                                    <img src="{{asset('public/Admin/images/logo.png')}}" width="88" alt="user-image" class="rounded-circle img-thumbnail">
                                    <h4 class="text-dark-50 text-center mt-3">Hi ! {{Auth::user()->name}} </h4>
                                    <p class="text-muted mb-4">Enter your password to access the Application.</p>
                                </div>

                                <h5 class="auth-title">Lock Screen</h5>
                                @if ($message = Session::get('error'))  
                                <div class="alert alert-danger alert-block">  
                                  <strong>{{ $message }}</strong>  
                                </div>  
                                @endif      
                                <form action="{{url('unLock')}}" method="post">

                                    <div class="form-group mb-3">
                                        <label for="password">Password</label>
                                        <input class="form-control" type="hidden" required="" id="email" name="email" placeholder="email" value="{{Auth::user()->email}}">
                                        <input class="form-control" type="password" required="" id="password" name="password" placeholder="Enter your password">
                                    </div>

                                    <div class="form-group mb-0 text-center">
                                        <button class="btn btn-danger btn-block" type="submit"> Log In </button>
                                    </div>

                                </form>

                            </div> <!-- end card-body -->
                            </div>
                            <!-- end card -->


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
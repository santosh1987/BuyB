<!DOCTYPE html>
<html lang="en">
    
     @include('layouts.head')
    <!-- Toastr -->
     <!-- Tost-->
      <!-- Jquery Toast css -->
      <!-- <link href="{{ url('public/Admin/css/toastr.min.css')}}" rel="stylesheet" type="text/css" />
     <script src="{{ url('public/Admin/css/toastr.min.js')}}"></script> -->
     
     
    <!-- toastr init js-->
    <!-- <script src="{{ url('public/Admin/js/pages/toastr.init.js')}}"></script> -->
    <body>

        <!-- Begin page -->
        <div id="wrapper">
                @include('layouts.topnavbar')
         
            <div class="left-side-menu">
                @include('layouts.sidemenu')
            </div> 

            <div class="content-page">
                 <!-- content -->
                 @yield('content')

               @include('layouts.footer')

            </div>

            
        </div>
        <!-- END wrapper -->
        <!-- <h1>hi</h1>  -->
        @include('layouts.scripts')
      
    </body>
</html>
<!DOCTYPE html>
<html lang="en">
    
     @include('Admin.subpages.head')
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
                @include('Admin.subpages.topnavbar')
         
            <div class="left-side-menu">
                @include('layouts.sidemenu')
            </div> 

            <div class="content-page">
                 <!-- content -->
                 @yield('content')

               @include('Admin.subpages.footer')

            </div>

            
        </div>
        <!-- END wrapper -->

        @include('layouts.scripts')
        
    </body>
</html>
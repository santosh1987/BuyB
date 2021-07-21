<!DOCTYPE html>
<html lang="en">
     @include('Vendor.subpages.head')

    <body>

        <!-- Begin page -->
        <div id="wrapper">
                @include('Vendor.subpages.topnavbar')
         
            <div class="left-side-menu">
                @include('layouts.sidemenu')
            </div> 

            <div class="content-page">
                 <!-- content -->
                 @yield('content')

               @include('Vendor.subpages.footer')

            </div>

            
        </div>
        <!-- END wrapper -->

        @include('Vendor.subpages.scripts')
        
    </body>
</html>
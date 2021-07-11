<!DOCTYPE html>
<html lang="en">
     @include('Admin.subpages.head')

    <body>

        <!-- Begin page -->
        <div id="wrapper">
                @include('Admin.subpages.topnavbar')
         
            <div class="left-side-menu">
                @include('Admin.subpages.leftsidebar')
            </div> 

            <div class="content-page">
                 <!-- content -->
                 @yield('content')

               @include('Admin.subpages.footer')

            </div>

            
        </div>
        <!-- END wrapper -->

        @include('Admin.subpages.scripts')
        
    </body>
</html>
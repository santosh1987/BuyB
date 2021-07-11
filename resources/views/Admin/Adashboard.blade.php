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
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">BuyBombay</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                            <li class="breadcrumb-item active">Dashboard</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Dashboard</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-xl-3">
                                <div class="card-box">
                                    <i class="fa fa-info-circle text-muted float-right" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="More Info"></i>
                                    <h4 class="mt-0 font-16">Wallet Balance</h4>
                                    <h2 class="text-primary my-4 text-center">$<span data-plugin="counterup">31,570</span></h2>
                                </div> <!-- end card-box-->
                            </div>
                            <div class="col-xl-3">
                                <div class="card-box">
                                    <i class="fa fa-info-circle text-muted float-right" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="More Info"></i>
                                    <h4 class="mt-0 font-16">Total User</h4>
                                    <h2 class="text-primary my-4 text-center"><span data-plugin="counterup">1802</span></h2>
                                </div> <!-- end card-box-->
                            </div>
                            <div class="col-xl-3">
                                <div class="card-box">
                                    <i class="fa fa-info-circle text-muted float-right" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="More Info"></i>
                                    <h4 class="mt-0 font-16">Total Order</h4>
                                    <h2 class="text-primary my-4 text-center"><span data-plugin="counterup">5014</span></h2>
                                </div> <!-- end card-box-->
                            </div>
                              
                        </div>
                        <!-- end row -->
                        
                    </div> <!-- container -->

                </div> <!-- content -->

               @include('Admin.subpages.footer')

            </div>

            
        </div>
        <!-- END wrapper -->

        @include('Admin.subpages.scripts')
        
    </body>
</html>
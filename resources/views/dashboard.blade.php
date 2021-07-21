@extends('Master')

@section('content')
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
                                <!-- <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li> -->
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Dashboard</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <!-- <div class="row">
                <div class="col-xl-3">
                    <div class="card-box">
                        <i class="fa fa-info-circle text-muted float-right" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="More Info"></i>
                        <h4 class="mt-0 font-16">Wallet Balance</h4>
                        <h2 class="text-primary my-4 text-center">$<span data-plugin="counterup">31,570</span></h2>
                    </div> end card-box
                </div>
                <div class="col-xl-3">
                    <div class="card-box">
                        <i class="fa fa-info-circle text-muted float-right" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="More Info"></i>
                        <h4 class="mt-0 font-16">Total User</h4>
                        <h2 class="text-primary my-4 text-center"><span data-plugin="counterup">1802</span></h2>
                    </div> end card-box
                </div>
                <div class="col-xl-3">
                    <div class="card-box">
                        <i class="fa fa-info-circle text-muted float-right" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="More Info"></i>
                        <h4 class="mt-0 font-16">Total Order</h4>
                        <h2 class="text-primary my-4 text-center"><span data-plugin="counterup">5014</span></h2>
                    </div> end card-box
                </div>
                
            </div> -->
            <!-- end row -->
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card-box">
                        <div class="dropdown float-right">
                            <!-- <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-horizontal"></i>
                            </a> -->
                            <div class="dropdown-menu dropdown-menu-right">
                                <!-- item-->
                                <!-- <a href="javascript:void(0);" class="dropdown-item">Action</a> -->
                                <!-- item-->
                                <!-- <a href="javascript:void(0);" class="dropdown-item">Another action</a> -->
                                <!-- item-->
                                <!-- <a href="javascript:void(0);" class="dropdown-item">Something else</a> -->
                                <!-- item-->
                                <!-- <a href="javascript:void(0);" class="dropdown-item">Separated link</a> -->
                            </div>
                        </div>

                        <h4 class="header-title mt-0 mb-2">New Vendors</h4>

                        <div class="mt-1">
                            <div class="float-left" dir="ltr">
                                <input data-plugin="knob" data-width="64" data-height="64" data-fgColor="#f05050 "
                                    data-bgColor="#F9B9B9" value="58"
                                    data-skin="tron" data-angleOffset="180" data-readOnly=true
                                    data-thickness=".15"/>
                            </div>
                            <div class="text-right">
                                <h2 class="mt-3 pt-1 mb-1"> 268 </h2>
                                <p class="text-muted mb-0">Since last week</p>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div><!-- end col -->

                <div class="col-xl-3 col-md-6">
                    <div class="card-box">
                        

                        <h4 class="header-title mt-0 mb-3">Total Orders</h4>

                        <div class="mt-1">
                            <div class="float-left" dir="ltr">
                                <input data-plugin="knob" data-width="64" data-height="64" data-fgColor="#675db7"
                                    data-bgColor="#e8e7f4" value="80"
                                    data-skin="tron" data-angleOffset="180" data-readOnly=true
                                    data-thickness=".15"/>
                            </div>
                            <div class="text-right">
                                <h2 class="mt-3 pt-1 mb-1"> 8715 </h2>
                                <p class="text-muted mb-0">Since last month</p>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div><!-- end col -->

                <div class="col-xl-3 col-md-6">
                    <div class="card-box">
                        
                        <h4 class="header-title mt-0 mb-3">Total Revenue</h4>

                        <div class="mt-1">
                            <div class="float-left" dir="ltr">
                                <input data-plugin="knob" data-width="64" data-height="64" data-fgColor="#23b397"
                                    data-bgColor="#c8ece5" value="77"
                                    data-skin="tron" data-angleOffset="180" data-readOnly=true
                                    data-thickness=".15"/>
                            </div>
                            <div class="text-right">
                                <h2 class="mt-3 pt-1 mb-1"> &#8377;925 </h2>
                                <p class="text-muted mb-0">This week</p>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div><!-- end col -->

                <div class="col-xl-3 col-md-6">
                    <div class="card-box">
                        

                        <h4 class="header-title mt-0 mb-3">Daily Average</h4>

                        <div class="mt-1">
                            <div class="float-left" dir="ltr">
                                <input data-plugin="knob" data-width="64" data-height="64" data-fgColor="#ffbd4a"
                                    data-bgColor="#FFE6BA" value="35"
                                    data-skin="tron" data-angleOffset="180" data-readOnly=true
                                    data-thickness=".15"/>
                            </div>
                            <div class="text-right">
                                <h2 class="mt-3 pt-1 mb-1"> &#8377;78.58 </h2>
                                <p class="text-muted mb-0">Revenue today</p>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div><!-- end col -->

            </div>
                        <!-- end row -->
        </div> <!-- container -->

    </div>
@endsection
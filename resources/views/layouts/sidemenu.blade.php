<?php 
// use Auth;
use App\Providers\RouteServiceProvider;
$susers = \App\Models\User::where('id',Auth::user()->id)->whereRoleIs(['superadministrator'])->get();
$vusers = \App\Models\User::where('id',Auth::user()->id)->whereRoleIs(['administrator','vendor'])->get();
$roleData = \App\Models\User::leftjoin('role_user', 'users.id','=', 'role_user.user_id')->select('role_user.role_id as id')->where('users.id', Auth::user()->id)->get();
$roleData = $roleData[0];
// print_r($roleData['id']);
// die();
?>
<script>
    // $(document).ready(function() { 
    //     var urlPath = window.location.href.split("/")[4];
        
    //     if(urlPath === '' || urlPath === 'home' || urlPath === 'index'){
    //         $("#vendors").removeClass("active");
    //         $("#masterProduct").removeClass("active");
    //         $("#dashboard").addClass("active");
    //     }
        
        
    // //your code
    // });
</script>

<div class="slimscroll-menu">

    <!--- Sidemenu -->
    <div id="sidebar-menu">
        <ul class="metismenu" id="side-menu">
            <li class="menu-title">Navigation</li>
            <li >
                <a href="{{url('dashboard')}}" id="dashboard">
                    <i class="la la-dashboard"></i>
                    <span> Dashboard</span>                     
                </a>               
            </li>
            @if($roleData['id'] == '1')
            <li >
                <a href="{{url('viewSlider')}}" id="slider">
                    <i class="la la-dashboard"></i>
                    <span> Manage Sliders</span>                     
                </a>               
            </li>
            <li>
                <a href="javascript: void(0);">
                    <i class="la la-cube"></i>
                    <span> Categories </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li>
                        <a href="{{url('viewCategory')}}">Master Categories</a>
                    </li>
                    <li>
                        <a href="{{url('viewSubCategory')}}">Sub Categories</a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript: void(0);">
                    <i class=" mdi mdi-alpha-p-circle"></i>
                    <span> Products </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li>
                        <a href="{{url('addProduct')}}">Add Products</a>
                    </li>
                    <li>
                        <a href="{{url('viewProduct')}}">View Products</a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript: void(0);">
                    <i class="fas fa-users"></i>
                    <span> Vendors </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li>
                        <a href="{{url('addVendor')}}">Add Vendors</a>
                    </li>
                    <li>
                        <a href="{{url('viewVendor')}}">View Vendors</a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript: void(0);">
                    <i class="fas fa-users-cog"></i>
                    <span> Administrators </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li>
                        <a href="{{url('addAdmin')}}">Add Admin</a>
                    </li>
                    <li>
                        <a href="{{url('viewAdmin')}}">View Administrators</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript: void(0);">
                    <i class="fas fa-cog"></i>
                    <span> Role Permissions </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav-second-level" aria-expanded="false">
                    <!-- <li>
                        <a href="addPermission">Add Permission</a>
                    </li> -->
                    <li>
                        <a href="{{url('viewPermission')}}">View Permission</a>
                    </li>
                    <li>
                        <a href="{{url('assignPermission')}}">Assign Permission</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript: void(0);">
                    <i class="fas fa-cog"></i>
                    <span> Role Management </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav-second-level" aria-expanded="false">
                    <!-- <li>
                        <a href="addPermission">Add Permission</a>
                    </li> -->
                    <li>
                        <a href="{{url('viewRole')}}">View Roles</a>
                    </li>
                    
                </ul>
            </li>
            @elseif($roleData['id'] == '3')
            <li>
                <a href="javascript: void(0);">
                    <i class="fas fa-shopping-basket"></i>
                    <span> Product Quantity Management </span>  
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li>
                        <a href="{{url('addProductRequest')}}">Add Product Request</a>
                    </li>
                    <li>
                        <a href="{{url('viewProductRequest')}}">View Product Request</a>
                    </li>
                    <li>
                        <a href="{{url('vendorInventory')}}">Inventory</a>
                    </li>
                    <li>
                        <a href="{{url('viewProductOffers')}}">View Offers</a>
                    </li>

                </ul>
            </li>
            <li>
                <a href="javascript: void(0);">
                    <i class="fas fa-chart-line"></i>
                    <span> Orders Management </span>  
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li>
                        <a href="#">View Orders</a>
                    </li>
                    <!-- <li>
                        <a href="{{url('viewProductRequest')}}">View Product Request</a>
                    </li>
                    <li>
                        <a href="{{url('vendorInventory')}}">Inventory</a>
                    </li> -->
                    
                </ul>
            </li>
            <li>
                <a href="javascript: void(0);">
                    <i class="fas fa-chart-bar"></i>
                    <span> Reports </span>  
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li>
                        <a href="#">View Reports</a>
                    </li>
                    <!-- <li>
                        <a href="{{url('viewProductRequest')}}">View Product Request</a>
                    </li>
                    <li>
                        <a href="{{url('vendorInventory')}}">Inventory</a>
                    </li> -->
                    
                </ul>
            </li>
            @elseif($roleData['id'] == '2')
            <li>
                <a href="javascript: void(0);">
                    <i class="fas fa-cog"></i>
                    <span> Manage Vendors </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li>
                        <a href="{url('addVendorRep')}}">Add Vendor </a>
                    </li>
                    <li>
                        <a href="{{url('viewProductRequest')}}">View Vendors</a>
                    </li>
                    <li>
                        <a href="{{url('viewReports')}}">View Reports</a>
                    </li>
                    
                </ul>
            </li>
            <li>
                <a href="{{url('viewReports')}}">
                    <i class="fas fa-chart-bar"></i>
                    <span> View Reports </span>
                </a>
            </li>
            @endif
           
        </ul>

    </div>
    <!-- End Sidebar -->

    <div class="clearfix"></div>

</div>
<?php 

use App\Providers\RouteServiceProvider;
$susers = \App\Models\User::where('id',Auth::user()->id)->whereRoleIs(['superadministrator'])->get();
$vusers = \App\Models\User::where('id',Auth::user()->id)->whereRoleIs(['administrator','vendor'])->get();

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
                <a href="dashboard" id="dashboard">
                    <i class="la la-dashboard"></i>
                    <span> Dashboard</span>                     
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
                        <a href="viewCategory">Master Categories</a>
                    </li>
                    <li>
                        <a href="viewSubCategory">Sub Categories</a>
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
                        <a href="addProduct">Add Products</a>
                    </li>
                    <li>
                        <a href="viewProduct">View Products</a>
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
                        <a href="addVendor">Add Vendors</a>
                    </li>
                    <li>
                        <a href="viewVendor">View Vendors</a>
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
                        <a href="addAdmin">Add Admin</a>
                    </li>
                    <li>
                        <a href="viewAdmin">View Administrators</a>
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
                        <a href="viewPermission">View Permission</a>
                    </li>
                    <li>
                        <a href="assignPermission">Assign Permission</a>
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
                        <a href="viewRole">View Roles</a>
                    </li>
                    
                </ul>
            </li>

           
        </ul>

    </div>
    <!-- End Sidebar -->

    <div class="clearfix"></div>

</div>
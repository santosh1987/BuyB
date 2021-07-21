<?php 
$susers = \App\Models\User::where('id',Auth::user()->id)->whereRoleIs(['superadministrator'])->get();
$vusers = \App\Models\User::where('id',Auth::user()->id)->whereRoleIs(['administrator','vendor'])->get();

die(!$vusers->isEmpty());
//seperating route based on role which is logged in
if(!$susers->isEmpty() && $vusers->isEmpty()) {
    return redirect()->intended(RouteServiceProvider::SHOME);
}
elseif ($susers->isEmpty() && !$vusers->isEmpty()) {
    return redirect()->intended(RouteServiceProvider::VHOME);
}


?>

<div class="slimscroll-menu">

    <!--- Sidemenu -->
    <div id="sidebar-menu">

        <ul class="metismenu" id="side-menu">

            <li class="menu-title">Navigation</li>

            <li>
                <a href="dashboard">
                    <i class="la la-dashboard">
                        
                    </i>
                    <span> Dashboard   </span>
                     
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
                        <a href="view-Category">Parent Categories</a>
                    </li>
                    <li>
                        <a href="view-SubCategory">Sub Categories</a>
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
                        <a href="apps-calendar.html">Add Products</a>
                    </li>
                    <li>
                        <a href="apps-contacts.html">View Products</a>
                    </li>
                </ul>
            </li>

           
        </ul>

    </div>
    <!-- End Sidebar -->

    <div class="clearfix"></div>

</div>
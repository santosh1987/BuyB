<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Models\VendorDetails;

class DashboardController extends Controller
{
    public function display() {
        $vendors = VendorDetails::all();
        $days_ago = date('Y-m-d h:i:s', mktime(0, 0, 0, date("m") , date("d") - 5, date("Y")));
        // echo $days_ago;
        $vendorsTime = VendorDetails::where('created_at', '>', $days_ago)->get();
        // die(count($vendorsTime)."hi");
        return view('dashboard', compact('vendors', 'vendorsTime'));
    }
}

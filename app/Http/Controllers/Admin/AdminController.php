<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DBFunctions\DBFunctionsController;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\View;

class AdminController extends Controller
{
    public function addAdmin(Request $request) {
        $method = $request->method();
        if ($request->isMethod('get')) {
            return view('admin.admins.addAdmin');
        }
    }
}

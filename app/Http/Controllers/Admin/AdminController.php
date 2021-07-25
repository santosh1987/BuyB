<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DBFunctions\DBFunctionsController;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Represents;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\View;



class AdminController extends Controller
{
    public function addAdmin(Request $request) {
        $method = $request->method();
        if ($request->isMethod('get')) {
            return view('admin.admins.addAdmin');
        }
        else if($request->isMethod('post')) {
            $values = $request->all();
            $represnts = array();
            $represnts['name'] = $values['name'];
            $represnts['email'] = $values['email'];;
            $represnts['phoneNo'] = $values['phoneNum'];
            $nDate = \Carbon\Carbon::createFromFormat('Y-m-d', $values['dob'])->format('Y-m-d');
            $represnts['dob'] = $nDate;
            $represnts['address'] = $values['address'];
            $represnts['status'] = "SUSPENDED";
            $represnts['createdBy'] = Auth::user()->id;
            $db_functions_ctrl = new DBFunctionsController();
            $table = "App\models\Represents";
            $val = $db_functions_ctrl->insertRetId1($table, $represnts);
            if($val>0) {
                $user = User::create([
                    'name' => $values['name'],
                    'email' => $values['email'],
                    'createdBy' => Auth::user()->id,
                    'password' => Hash::make("123456789"),
                ]);
        
                $user->attachRole('administrator');
                event(new Registered($user));
        
                
                return "success";
            }
            else {
                return "failed";
            }
        }
    }
    public function display() {
        $represents = Represents::all();
        return view('admin.admins.viewAdmin', compact('represents'));
    }
}

<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\DBFunctions\DBFunctionsController;
use Illuminate\Support\Facades\Hash;
use Auth;
class ProfileController extends Controller
{
    public function changePassword(Request $request) {
        $values = $request->all();
        $user = array();
        $user['password'] = Hash::make($values['password']);
        $data = array();
        $data['id'] = Auth::user()->id;
        $table = "\App\Models\User";
        $db_functions_ctrl = new DBFunctionsController();
        $val = $db_functions_ctrl->update($table, $user, $data);
        if($val > 0){
            Auth::logout();
            return redirect('/login');
        }
        else {
            return back()->with($errors);
        }
    }
    public function unLock(Request $request) {
        $values = $request->all();
        // print_r($values);
        if (Auth::attempt(['email' => $values['email'], 'password' => $values['password']]))
        {
            return redirect()->intended('dashboard');
        }
        else {
            return back()->with('error', 'Password incorrect');
        }
    }
}

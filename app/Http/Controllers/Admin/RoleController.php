<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DBFunctions\DBFunctionsController;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\VendorDetails;
use App\Models\VendorGstDetails;
use App\Models\Role;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\View;

class RoleController extends Controller
{
    public function addRole(Request $request) {
        $method = $request->method();

        if ($request->isMethod('get')) {
            return view('admin.role.addRole');
        }
    }
    public function viewRole(Request $request) {
        $roles = Role::all();
       return view('admin.role.viewRole', compact('roles'));
    }
    
    public function saveRole(Request $request) {
        $values = $request->all();
        $role = array();
        $role['name'] = $values['roleName'];
        $role['display_name'] = $values['displayName'];
        $role['description'] = $values['description'];
        $db_functions_ctrl = new DBFunctionsController();
        $table = "App\models\Role";
        $val = $db_functions_ctrl->insert($table, $role);
        if($val > 0) {
            return "success";
        }
        return "failed";
    }
    public function getRole(Request $request) {
        $values = $request->all();
        $role = Role::where('id', $values['id'])->get();
        return $role->toJson();
    }
    public function updateRole(Request $request) {
        $values = $request->all();
        $role = array();
        $role['name'] = $values['roleName'];
        $role['display_name'] = $values['displayName'];
        $role['description'] = $values['description'];
        $db_functions_ctrl = new DBFunctionsController();
        $table = "App\models\Role";
        $data = array();
        $data['id'] = $values['id'];
        $val = $db_functions_ctrl->update($table, $role, $data);
        if($val > 0) {
            return "success";
        }
        return "failed";
    }
    public function deleteRole(Request $request) {
        $values = $request->all();
        $role = Role::find($values['id']);
        $role->delete();
        return "success";
    }

}

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
use App\Models\Permission;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\View;

class PermissionController extends Controller
{
    public function addPermission(Request $request) {
        $method = $request->method();

        if ($request->isMethod('get')) {
            return view('admin.permission.addPermission');
        }
    }
    public function viewPermission(Request $request) {
        $permissions = Permission::all();
       return view('admin.permission.viewPermission', compact('permissions'));
    }
    
    public function savePermission(Request $request) {
        $values = $request->all();
        $permission = array();
        $permission['name'] = $values['permissionName'];
        $permission['display_name'] = $values['displayName'];
        $permission['description'] = $values['description'];
        $db_functions_ctrl = new DBFunctionsController();
        $table = "App\models\Permission";
        $val = $db_functions_ctrl->insert($table, $permission);
        if($val > 0) {
            return "success";
        }
        return "failed";
    }
    public function getPermission(Request $request) {
        $values = $request->all();
        $permission = Permission::where('id', $values['id'])->get();
        return $permission->toJson();
    }
    public function updatePermission(Request $request) {
        $values = $request->all();
        $permission = array();
        $permission['name'] = $values['permissionName'];
        $permission['display_name'] = $values['displayName'];
        $permission['description'] = $values['description'];
        $db_functions_ctrl = new DBFunctionsController();
        $table = "App\models\Permission";
        $data = array();
        $data['id'] = $values['id'];
        $val = $db_functions_ctrl->update($table, $permission, $data);
        if($val > 0) {
            return "success";
        }
        return "failed";
    }
    public function deletePermission(Request $request) {
        $values = $request->all();
        $permission = Permission::find($values['id']);
        $permission->delete();
        return "success";
    }
    
}

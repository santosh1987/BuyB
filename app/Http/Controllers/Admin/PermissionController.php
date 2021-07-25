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
use App\Models\PermissionRole;
use App\Models\Role;
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

    public function assignPermission(Request $request) {
        $permissions = Permission::all();
        $roles = Role::all();
        return view('admin.permission.assignPermission', compact('permissions', 'roles'));
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
    
    public function getPermissionByRoleId(Request $request) {
        $permissionRole = PermissionRole::leftjoin('permissions', 'permission_role.permission_id', '=', 'permissions.id')->select('permissions.name', 'permissions.display_name', 'permissions.description', 'permissions.id')->where('permission_role.role_id', $request['id'])->get();
        return $permissionRole->toJson();
    }
    public function getNotAssignedPermissionByRoleId(Request $request) {
        // $permissions = Permission::select('permissions.id')->get();
        $permissionRole = PermissionRole::select('permission_role.permission_id')->where('permission_role.role_id', $request['id'])->get();
        $permissions = Permission::select('permissions.id', 'permissions.name')->whereNotIn('id', $permissionRole)->get();
        // die($permissions);
        return $permissions->toJson();
    }

    public function updatePermissions(Request $request) {
        $values = $request->all();
        // print_r($values);
        $permissions = PermissionRole::where('role_id',$values['id'])->select('id')->get();
        // die($permissions);
       
        foreach($permissions as $permission) {
            // print_r($permission['id'] . " , ");
            $permission = PermissionRole::find($permission['id']);
            $permission->delete();
        }
        // die();

        $permissionData = array();
        // $permissionData['permission_id'] = $id;
        $permissionData['role_id'] = $values['id'];
        $cnt = 0;
        // die($values['selected']);
        foreach($values['selected'] as $selected) {
            // echo $selected;
            // echo "selected";
            $permissionData['permission_id'] = $selected;
            $db_functions_ctrl = new DBFunctionsController();
            $table = "App\models\PermissionRole";
            $val = $db_functions_ctrl->insert($table, $permissionData);
            if($val > 0) {
                $cnt = $cnt + 1;
            }
        }
        if($cnt == count($values['selected'])) {
            return "success";
        }
        return "failed";


    }

    
}

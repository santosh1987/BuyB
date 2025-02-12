<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DBFunctions\DBFunctionsController;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\VendorDetails;
use App\Models\Represents;
use App\Models\VendorGstDetails;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\View;

class VendorController extends Controller
{
    public function insert(Request $request) {
        $method = $request->method();

        if ($request->isMethod('get')) {
            return view('admin.vendors.addVendor');
        }
        else if($request->isMethod('post')) {
            $values = $request->all();
            // print_r($values);
            $jsonData = json_decode($values['jsonData']);
            // print_r($jsonData);
            $vendorName = $jsonData->data->lgnm;
            $tradeName = $jsonData->data->tradeNam;
            $gstNo = $jsonData->data->gstin;
            $phoneNo = $values['phoneNum'];
            $email = $values['email'];
            $state = $jsonData->data->pradr->addr->stcd;
            $ctjd = $jsonData->data->ctj;
            $stjd = $jsonData->data->stj;
            $ctjcd = $jsonData->data->ctjCd;
            $rgdate = $jsonData->data->rgdt;
            $taxType = $jsonData->data->dty;
            $status = "";
            // die($jsonData->data->sts);
            if($jsonData->data->sts === "Suspended") {
                $status = "SUSPENDED";
            }
            else if(($jsonData->data->sts === "Active")) {
                // die('hi');
                $status = "Active";
            }
            // die($status);
            $address = $jsonData->data->pradr->addr->bno . "/". $jsonData->data->pradr->addr->loc. "/". $jsonData->data->pradr->addr->dst . "/". $jsonData->data->pradr->addr->stcd ."/" . $jsonData->data->pradr->addr->pncd;
            // print_r($address);
            $vendorData = array();
            $vendorData['vendorName'] = $vendorName;
            $vendorData['email'] = $email;
            $vendorData['phoneNo'] = $phoneNo;
            $vendorData['address'] = $address;
            $vendorData['gstNo'] = $gstNo;
            $vendorData['status'] = "SUSPENDED";
            $db_functions_ctrl = new DBFunctionsController();
            $table = "App\models\VendorDetails";
            $val = $db_functions_ctrl->insertRetId1($table, $vendorData);
            if($val>0) {
                $user = User::create([
                    'name' => $vendorName,
                    'email' => $email,
                    'password' => Hash::make("123456789"),
                ]);
        
                $user->attachRole('vendor');
                $user->attachPermission('dashboard-read');
                event(new Registered($user));
        
                // Auth::login($user);
                $vendorGstData = array();
                $vendorGstData['vendorId'] = $val;
                $vendorGstData['legalBusinessName'] = $tradeName;
                $vendorGstData['tradeName'] = $tradeName;
                $vendorGstData['gstNo'] = $gstNo;
                $vendorGstData['address'] = $address;
                $vendorGstData['stateJuridiction'] = $stjd;
                $vendorGstData['CentreJuridiction'] = $ctjd;
                // echo $rgdate;
                


                // $date = "20/07/2021";
	            $nDate = \Carbon\Carbon::createFromFormat('d/m/Y', $rgdate)->format('Y-m-d');
                // die($newDate);
                // $nDate = date("Y-m-d", strtotime($rgdate));
                // echo $nDate;
                $vendorGstData['dateOfRegistration'] = $nDate;
                // $vendorGstData['constitutionOfBusiness'] = $gstNo;
                $vendorGstData['taxPayerType'] = $taxType;
                // $vendorGstData['dataStore'] = $gstNo;
                // die($status);
                $vendorGstData['status'] = $status;
                $db_functions_ctrl = new DBFunctionsController();
                $table = "App\models\VendorGstDetails";
                $val1 = $db_functions_ctrl->insert($table, $vendorGstData);
                if($val1 > 0) {
                    echo "success";
                }
                else {
                    echo "failed";
                }
            }
            else {
                return "failed";
            }

        }
    }
    public function getGstDetails(Request $request) {
        $id = $request['id'];
        $response = Http::get("http://sheet.gstincheck.ml/check/a72bf91d919f98f6dcdcc4d67c43279c/$id", [
        ]);
        // $client = new http\Client;
        // $request = new http\Client\Request;
        // $request->setRequestUrl("http://sheet.gstincheck.ml/check/251caf64f95848da9bec8690aa09939f/{{$request['id']}}");
        // $request->setRequestMethod('GET');
        // $request->setOptions(array());

        // $client->enqueue($request)->send();
        // $response = $client->getResponse();
        // echo $response->getBody();
        print($response);
    }


    public function checkEmail(Request $request) {
        $email = $request['email'];
        $users = User::where('email', $email)->get();
        $usersTrashed = User::withTrashed()->where('email', $email)->get();
        if(count($users) > 0 || count($usersTrashed) > 0) {
            return "yes";
        }
        return "no";
    }
    public function checkMobile(Request $request) {
        $mobile = $request['mobile'];
        $represents = Represents::where('phoneNo', $mobile)->get();
        $representsTrashed = Represents::where('phoneNo', $mobile)->get();
        $users = VendorDetails::withTrashed()->where('phoneNo', $mobile)->get();
        $usersTrashed = VendorDetails::withTrashed()->where('phoneNo', $mobile)->get();
        if(count($users) > 0 || count($usersTrashed) > 0 || count($represents) > 0 || count($representsTrashed) > 0) {
            return "yes";
        }
        return "no";
    }
    public function checkGst(Request $request) {
        $gst = $request['gst'];
        $users = VendorGstDetails::where('gstNo', $gst)->get();
        $usersTrashed = VendorGstDetails::withTrashed()->where('gstNo', $gst)->get();
        if(count($users) > 0 || count($usersTrashed) > 0) {
            return "yes";
        }
        return "no";
    }

    public function viewVendor() {
        $vendors = VendorDetails::all();
        return View::make('Admin.Vendors.viewVendor', compact('vendors'));
    }
    public function getVendorStatus(Request $request) {
        $values = $request->all();
        $vendors = VendorDetails::where('id', $values['id'])->get();
        return $vendors->toJson();
    }

    public function updateVendor(Request $request) {
        $values = $request->all();
        $vendor = array();
        $vendor['vendorName'] = $values['vendorName'];
        $vendor['alternatePhon'] = $values['alternate'];
        $vendorData = array();
        $vendor['vendorName'] = $values['vendorName'];
        $db_functions_ctrl = new DBFunctionsController();
        $data = array();
        $data['id'] = $values['id'];
        $table = "App\models\VendorDetails";
        $val = $db_functions_ctrl->update($table, $vendor, $data);
        if($val > 0) {
            return "success";
        }
        return "failed";
    }

    public function deleteVendor(Request $request) {
        $values = $request->all();
        $vendor = VendorDetails::find($request['id']);
        $vendor->delete();

        $vendorGstData = VendorGstDetails::where('vendorId', $values['id'])->get();
        $vendorGstData = $vendorGstData[0];
        $vendorGst = VendorGstDetails::find($vendorGstData['id']);
        $vendorGst->delete();

        $userData = \App\models\User::where('email', $vendor['email'])->get();
        $users = User::find($userData[0]['id']);
        $users->delete();
        return "success";

    }

    public function changeStatus(Request $request) {
        $values = $request->all();
        $vendor = array();
        $vendors = VendorDetails::find($values['id']);
        $status = "";
        if($vendors['status'] === "SUSPENDED") {
            $status = "ACTIVE";
        }
         else if ($vendors['status'] === "ACTIVE") {
            $status = "SUSPENDED";
         }
         else if ($vendors['status'] === "IN-ACTIVE") {
            $status = "SUSPENDED";
         }
        //  die($vendor);
        $vendor['status'] = $status;
        $db_functions_ctrl = new DBFunctionsController();
        $data = array();
        $data['id'] = $values['id'];
        $table = "App\models\VendorDetails";
        $val = $db_functions_ctrl->update($table, $vendor, $data);
        if($val > 0) {
            return "success";
        }
        return "failed";
    }
    
}

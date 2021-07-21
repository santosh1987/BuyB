<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//Twillio API
use Twilio\Rest\Client;

class APIController extends Controller
{
    
     /**
     * this mehtod for sendOtp for requested customer as a response will get verification code and status
     *
     * @return response()
     */
    public function sendOtp(Request $request){
        $receiverNumber = "+91".$request['mobile'];
        $message = "This is testing from Bombay Buy";
        try {
  
            // $account_sid = getenv("TWILIO_SID");
            $account_sid = "ACc28ee03f98676c0fc6a2903916cf4ed3";
            $auth_token = "c2b0114b1cff8e9d65c9574cd035305d";
            // $auth_token = getenv("TWILIO_TOKEN");
            // $twilio_number = getenv("TWILIO_FROM");
            $twilio_number = "+12818253017";
            $twilio_verify_sid = "VAc0cc49f29ff7b0ff49fb19ffa280e81e";
            // $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
  
            $twilio = new Client($account_sid, $auth_token);
            $mobile = "+91".$request['mobile'];
            $data = $twilio->verify->v2->services("VAc0cc49f29ff7b0ff49fb19ffa280e81e")
                            ->verifications->create($mobile, "sms");
            echo $data->sid;
          
  
        } catch (Exception $e) {
            dd("Error: ". $e->getMessage());
        }
    }

    /* this function is to verify the mobile */

    public function verifyCode(Request $request)
    {
        $values = $request->all();
        // $client = new \GuzzleHttp\Client();
        $code = $values['verificationCode'];
        $phoneNum = $values['phoneNum'];
        // echo $code."---".$phoneNum;
        
        // and set the environment variables. See http://twil.io/secure
        // $account_sid = getenv("TWILIO_SID");
        $account_sid = "ACc28ee03f98676c0fc6a2903916cf4ed3";
        $auth_token = "c2b0114b1cff8e9d65c9574cd035305d";
        // $auth_token = getenv("TWILIO_TOKEN");
        // $twilio_number = getenv("TWILIO_FROM");
        $twilio_number = "+12818253017";
        $twilio_verify_sid = "VAc0cc49f29ff7b0ff49fb19ffa280e81e";
        // $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        $twilio = new Client($account_sid, $auth_token);

        $verification_check = $twilio->verify->v2->services("VAc0cc49f29ff7b0ff49fb19ffa280e81e")
                                                ->verificationChecks
                                                ->create($code, // code
                                                        ["to" => "+91".$phoneNum]);

        print($verification_check->status);
  
    }

 
}

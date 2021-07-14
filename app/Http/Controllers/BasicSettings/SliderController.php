<?php

namespace App\Http\Controllers\BasicSettings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function slide() {
        //$img = $request->file('file');
        $allowedExts = array('jpg', 'png', 'jpeg');

        $rules = [
            'file' => [
                function ($attribute, $value, $fail) use ($img, $allowedExts) {
                    if (!empty($img)) {
                        $ext = $img->getClientOriginalExtension();
                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only png, jpg, jpeg image is allowed");
                        }
                    }
                },
            ],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json(['errors' => $validator->errors(), 'id' => 'slider']);
        }

        $filename = time() . '.' . $img->getClientOriginalExtension();
        $request->session()->put('slider_image', $filename);
        $request->file('file')->move('assets/front/img/sliders/', $filename);
        return response()->json(['status' => "session_put", "image" => "slider_image", 'filename' => $filename]);
    }
}

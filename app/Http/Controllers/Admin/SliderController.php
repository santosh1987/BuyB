<?php

namespace App\Http\Controllers\Admin;
use Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\DBFunctions\DBFunctionsController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SliderController extends Controller
{
    public function display() {
        $sliders = Slider::all();
        return view('admin.slider', compact('sliders'));
    }
    public function insert(Request $request) {
        $validator = Validator::make($request->all(), [
            'sliderTitle' => 'required|string|max:100',
            'sliderText' => 'required|string|min:5|max:255',
            'buttonText' => 'required|string|min:5|max:255',
            'buttonUrl' => 'required|string|min:5|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('viewCategory')
                        ->withErrors($validator)
                        ->withInput();
        }
        // echo "hi";
        if($request->hasFile('image')) {
            $slider = new Slider;
            $path1 = "sliders";
            // die($path1);
            $fileName = $request->file('image')->getClientOriginalName();
            $path = $request->file('image')->storeAs(
                $path1,$fileName
            );
            $slider->title = $request->sliderTitle;
            $slider->text = $request->sliderText;
            $slider->buttonText = $request->buttonText;
            $slider->buttonUrl = $request->buttonUrl;
            $slider->imagePath = $path;
            $slider->createdBy = Auth::user()->id;

            $slider->save();
            if($slider != "") {
                return "success";
            }
            return "failed";
            // return back()->with('message','slider Added!!');
        }
    }
    public function getSliderById(Request $request) {
        $sliders = Slider::where('id', $request['id'])->get();
        return $sliders->toJson();
    }

    public function updateSlider(Request $request) {
        // echo $values['id'];
        $values = $request->all();
        $sliders = Slider::where('id',$values['id'])->get();
        $image = $sliders[0]['imagePath'];
        $path1 = "sliders/";
        // echo $image;
        $slidersUpd = array();
        $imageUrl = explode("/", $image);
        $fileName = end($imageUrl);
        if($values['imageChange'] == 'yes' && $request->hasFile('image'))
        {
            if (Storage::exists($image)) {
                Storage::delete($image);
            }
            $fileName = $request->file('image')->getClientOriginalName();
            // print($fileName);
            $logoPath = $request->file('image')->storeAs(
                    $path1,$fileName
                );
            $slidersUpd['imagePath'] = $logoPath;
            // print($logoPath);
        }
        
        $slidersUpd['title'] = $request->get('sliderTitle');
        $slidersUpd['text'] = $request->get('sliderText');
        $slidersUpd['buttonText'] = $request->get('buttonText');
        $slidersUpd['buttonUrl'] = $request->get('buttonUrl');
        $db_functions_ctrl = new DBFunctionsController();
        $table = "App\models\Slider";
        $data = array();
        $data['id'] = $request['id'];
        $val = $db_functions_ctrl->update($table, $slidersUpd,$data);
        // echo $val;
        if($val>0)
            return "success";
        else
            return "failed";        
    }
    public function deleteSlider(Request $request) {
        $values = $request->all();
        $slider = Slider::where('id',$values['id'])->get();
        $slider = $slider[0];        
        $img = $slider['imagePath'];
        Storage::delete($img);
        // die();
        $status = \App\models\Slider::withTrashed()
                ->where('id', $values['id'])
                ->delete();
        if($status>0)
            return "success";
        else
            return "failed";
    }

    public function changeStatusSlide(Request $request) {
        $values = $request->all();
        $slider = Slider::where('id', $values['id'])->get();
        $slider = $slider[0];
        $sliders = array();
        $status = '';
        if($slider['status'] == 'ACTIVE') {
            $status = "IN-ACTIVE";
        }
        else {
            $status = "ACTIVE";
        }
        $sliders['status'] = $status;
        $db_functions_ctrl = new DBFunctionsController();
        $table = "App\models\Slider";
        $data = array();
        $data['id'] = $values['id'];
        $val = $db_functions_ctrl->update($table, $sliders, $data);
        // die($val);
        if($val > 0) {
            return "success";
        }
        return "failed";
    }


}

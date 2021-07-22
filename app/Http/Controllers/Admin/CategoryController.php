<?php

namespace App\Http\Controllers\Admin;
use Auth;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\DBFunctions\DBFunctionsController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //
    public function insert(Request $request) {

        // $validator = $request->validate([
        //     'catName' => 'required|string|max:100',
        //     'catDesc' => 'required|string|min:4|max:255',
        //     ]
        // );

        $validator = Validator::make($request->all(), [
            'catName' => 'required|string|max:100',
            'catDesc' => 'required|string|min:5|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('viewCategory')
                        ->withErrors($validator)
                        ->withInput();
        }
        $category = new Category;

        $category->categoryName = $request->catName;
        $category->description = $request->catDesc;
        $category->createdBy = Auth::user()->id;

        $category->save();

        return back()->with('message','Category Added!!');

    }

    public function updateCategory(Request $request) {
        $values = $request->all();
        $category = array();
        $category['categoryName'] = $values['catName'];
        $category['description'] = $values['catDesc'];
        $db_functions_ctrl = new DBFunctionsController();
        $table = "App\models\Category";
        $data = array();
        $data['id'] = $values['id'];
        $val = $db_functions_ctrl->update($table, $category, $data);
        if($val > 0) {
            return "success";
        }
        return "failed";

    }

    public function changeStatusCat(Request $request) {
        $values = $request->all();
        $catData = Category::where('id', $values['id'])->get();
        $catData = $catData[0];
        $category = array();
        $status = '';
        if($catData['status'] == 'ACTIVE') {
            $status = "IN-ACTIVE";
        }
        else {
            $status = "ACTIVE";
        }
        $category['status'] = $status;
        $db_functions_ctrl = new DBFunctionsController();
        $table = "App\models\Category";
        $data = array();
        $data['id'] = $values['id'];
        $val = $db_functions_ctrl->update($table, $category, $data);
        if($val > 0) {
            return "success";
        }
        return "failed";

    }

    public function display()
    {
        $categories = Category::all();

        return view('Admin.categories.viewCategories',compact('categories'));
    }

     /* 
        To get the Category Details
        @params no
        @return Json Data of all categories 
    */
    public function getMasterCategoryById(Request $request) {
        $masterCategory = Category::select('id','categoryName', 'description','status')->where('id', $request['id'])->get();
        return $masterCategory->toJson();
    }

    public function deleteCategory(Request $request) {
        $category = Category::find($request['id']);
        $category->delete();
        return "success";
    }
}

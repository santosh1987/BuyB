<?php

namespace App\Http\Controllers\Admin;
use Auth;
use App\Models\Category;
use App\Models\SubCategories;
use Illuminate\Http\Request;
use App\Http\Controllers\DBFunctions\DBFunctionsController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
    //
    public function insert(Request $request) {

        // $validator = $request->validate([
        //     'catName' => 'required|string|max:100',
        //     'catDesc' => 'required|string|min:4|max:255',
        //     ]
        // );
        
        $validator = Validator::make($request->all(), [
            'catId' => 'required|int',
            'subCatName' => 'required|string|max:100',
            'subCatDesc' => 'required|string|min:2|max:255',
        ]);

        if ($validator->fails()) {
            // die('hi fails');
            return redirect('viewSubCategory')
                        ->withErrors($validator)
                        ->withInput();
        }
        $subcategory = new SubCategories;

        $subcategory->subCategoryName = $request->subCatName;
        $subcategory->description = $request->subCatDesc;
        $subcategory->catId = $request->catId;
        $subcategory->createdBy = Auth::user()->id;

        $subcategory->save();
        // echo "hi";
        // die();

        return back()->with('message','Sub Category Added!!');

    }

    public function updateSubCat(Request $request) {
        $values = $request->all();
        $category = array();
        $category['catId'] = $values['catId'];
        $category['subCategoryName'] = $values['subCatName'];
        $category['description'] = $values['subCatDesc'];
        $db_functions_ctrl = new DBFunctionsController();
        $table = "App\models\SubCategories";
        $data = array();
        $data['id'] = $values['id'];
        $val = $db_functions_ctrl->update($table, $category, $data);
        if($val > 0) {
            return back()->with('message','Sub Category Updated!!');
        }
        return back()->with('message','Sub Category Failed!!');

    }

    public function changeStatusSubCat(Request $request) {
        $values = $request->all();
        $subCatData = SubCategories::where('id', $values['id'])->get();
        $subCatData = $subCatData[0];
        $subCategory = array();
        $status = '';
        if($subCatData['status'] == 'ACTIVE') {
            $status = "IN-ACTIVE";
        }
        else {
            $status = "ACTIVE";
        }
        $subCategory['status'] = $status;
        $db_functions_ctrl = new DBFunctionsController();
        $table = "App\models\SubCategories";
        $data = array();
        $data['id'] = $values['id'];
        $val = $db_functions_ctrl->update($table, $subCategory, $data);
        // die($val);
        if($val > 0) {
            return "success";
        }
        return "failed";

    }

    public function display()
    {
        $subcategories = SubCategories::leftjoin('categories', 'categories.id', '=', 'subcategories.catId')->select('categories.categoryName', 'subcategories.id','subcategories.status', 'subcategories.subCategoryName', 'subcategories.description')->get();

        return view('admin.categories.viewSubCategories',compact('subcategories'));
    }

     /* 
        To get the Category Details
        @params no
        @return Json Data of all categories 
    */
    public function getSubMasterCategoryById(Request $request) {
        $subcategories = SubCategories::leftjoin('categories', 'categories.id', '=', 'subcategories.catId')->select('categories.categoryName', 'subcategories.id', 'subcategories.status','subcategories.subCategoryName', 'subcategories.description', 'subcategories.catId')->where('subcategories.id', $request['id'])->get();
        return $subcategories->toJson();
    }

    public function deleteSubCategory(Request $request) {
        $category = SubCategories::find($request['id']);
        $category->delete();
        return "success";
    }

    public function getSubMasterCategoryByCatId(Request $request) {
        $subcategories = SubCategories::leftjoin('categories', 'categories.id', '=', 'subcategories.catId')->select('categories.categoryName', 'subcategories.id', 'subcategories.status','subcategories.subCategoryName', 'subcategories.description', 'subcategories.catId')->where('subcategories.catId', $request['id'])->get();
        return $subcategories->toJson();
    }
}

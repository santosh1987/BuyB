<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
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

        $category->save();

        return back()->with('message','Category Added!!');

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
}

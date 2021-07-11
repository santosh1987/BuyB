<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    //
    public function insert(Request $request) {

        $request->validate([
            'catName' => 'required|string|max:100',
            'catDesc' => 'required|string|min:5|max:255',
            ]
        );
        
        $category = new Category;

        $category->category_name = $request->catName;
        $category->description = $request->catDesc;

        $category->save();

        return back()->with('message','Category Added!!');

    }

    public function display()
    {
        $categories = Category::all();

        return view('Admin.categories.viewCategories',compact('categories'));
    }
}

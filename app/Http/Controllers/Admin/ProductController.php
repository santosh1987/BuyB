<?php

namespace App\Http\Controllers\Admin;
use Auth;
use App\Models\Category;
use App\Models\SubCategories;
use App\Models\MasterProducts;
use Illuminate\Http\Request;
use App\Http\Controllers\DBFunctions\DBFunctionsController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
class ProductController extends Controller
{
    public function addProduct(Request $request) {
        $categories = Category::where('status',"ACTIVE")->get();
        return view('admin.categories.addProduct',compact('categories'));
    }

    public function viewProduct(Request $request) {
        $products = MasterProducts::leftjoin('categories','categories.id','=','masterproducts.catId')->leftjoin('subcategories','masterproducts.subCatId','=','subcategories.id')->select('categories.categoryName', 'subcategories.subCategoryName', 'masterproducts.productName','masterproducts.id', 'masterproducts.imagePath', 'masterproducts.description')->where('masterproducts.status',"ACTIVE")->get();
        return view('admin.categories.viewProduct',compact('products'));
    }

    /* 
            Saving product in master table 
            @param Form Data
            @return success or failure
    */
    public function saveProduct(Request $request) {
        if ($request->hasFile('file')) 
        {
            $path1 = $request->get('categoryName')."/".$request->get('subCategoryName');
            // die($path1);
            $fileName = $request->file('file')->getClientOriginalName();
            $path = $request->file('file')->storeAs(
                $path1,$fileName
            );
            $fname = explode(".",$request->file('file')->getClientOriginalName());
            $productData = array();
            $productData['catId'] = $request->get('categoryName');
            $productData['subCatId'] = $request->get('subCategoryName');
            $productData['productName'] = $request->get('productName');
            $productData['description'] = $request->get('description');
            $productData['imagePath'] = $path;
            
            
            $db_functions_ctrl = new DBFunctionsController();
            $table = "App\models\MasterProducts";
            $val = $db_functions_ctrl->insert($table, $productData);
        
            if($val>0)
                return "success";
            else
                return "failed";
            

        }
        else{
            echo "no File";
        }
    }
}

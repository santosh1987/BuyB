<?php

namespace App\Http\Controllers\Admin;
use Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\SubCategories;
use App\Models\MasterProducts;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\DBFunctions\DBFunctionsController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
class ProductController extends Controller
{
    public function addProduct(Request $request) {
        $categories = Category::where('status',"ACTIVE")->get();
        $products = null;
        $subcategories = null;
        return view('admin.categories.addProduct',compact('categories', 'products', 'subcategories'));
    }

    public function viewProduct(Request $request) {
        $products = MasterProducts::leftjoin('categories','categories.id','=','masterproducts.catId')->leftjoin('subcategories','masterproducts.subCatId','=','subcategories.id')->select('categories.categoryName', 'subcategories.subCategoryName', 'masterproducts.productName','masterproducts.id', 'masterproducts.imagePath', 'masterproducts.description', 'masterproducts.status')->get();
        return view('admin.categories.viewProduct',compact('products'));
    }
    public function updateProduct(Request $request, $id) {
        if($request->method('get')) {
            $categories = Category::all();        
            $products = MasterProducts::leftjoin('categories','categories.id','=','masterproducts.catId')->leftjoin('subcategories','masterproducts.subCatId','=','subcategories.id')->select('categories.categoryName', 'subcategories.subCategoryName', 'masterproducts.productName','masterproducts.id', 'masterproducts.imagePath', 'masterproducts.description', 'masterproducts.catId', 'masterproducts.subCatId', 'masterproducts.status')->where('masterproducts.status',"ACTIVE")->where('masterproducts.id', $id)->get();
            // echo $products[0]['catId'];
            // die();
            $subcategories = SubCategories::where('catId', $products[0]['catId'])->get();

            // die($subcategories);
            return view('admin.categories.addProduct',compact('products'), ['categories' => $categories, 'subcategories' =>$subcategories, "products" => $products]);
        } 
    }

    public function updateProductData(Request $request) {
        $values = $request->all();
        // echo $values['id'];
        $productDetails = \App\models\MasterProducts::where('id',$values['id'])->get();
        $image = $productDetails[0]['imagePath'];
        $path1 = $request->get('categoryName')."/".$request->get('subCategoryName');
        // echo $image;
        $productDetailsUpd = array();
        $imageUrl = explode("/", $image);
        $fileName = end($imageUrl);
        if($values['imageChange'] == 'yes' && $request->hasFile('file'))
        {
            if (Storage::exists($image)) {
                Storage::delete($image);
            }
            $fileName = $request->file('file')->getClientOriginalName();
            // print($fileName);
            $logoPath = $request->file('file')->storeAs(
                    $path1,$fileName
                );
            $productDetailsUpd['imagePath'] = $logoPath;
            // print($logoPath);
        }
        else if($values['catChange'] == 'yes' && !$request->hasFile('file') && $values['subCatChange'] == 'yes')
        {
            
            if (Storage::exists($path1."/".$fileName)) {
                Storage::delete($path1."/".$fileName);
            }
            Storage::move($image, $path1."/".$fileName);
            // Storage::move($image, 'move/test_move.png');
            if (Storage::exists($image)) {
                echo("hi");
                Storage::delete($image);
            }
        
            $productDetailsUpd['imagePath'] = $path1."/".$fileName;
            // print($logoPath);
        }
        else if($values['catChange'] == 'no' && !$request->hasFile('file') && $values['subCatChange'] == 'yes')
        {
        
            if (Storage::exists($path1."/".$fileName)) {
                Storage::delete($path1."/".$fileName);
            }
            Storage::move($image, $path1."/".$fileName);
            // Storage::move($image, 'move/test_move.png');
            if (Storage::exists($image)) {
                echo("hi");
                Storage::delete($image);
            }
        
            $productDetailsUpd['imagePath'] = $path1."/".$fileName;
            // print($logoPath);
        }
        $productDetailsUpd['catId'] = $request->get('categoryName');
        $productDetailsUpd['subCatId'] = $request->get('subCategoryName');
        $productDetailsUpd['productName'] = $request->get('productName');
        $productDetailsUpd['description'] = $request->get('description');
        $db_functions_ctrl = new DBFunctionsController();
        $table = "App\models\MasterProducts";
        $data = array();
        $data['id'] = $request['id'];
        $val = $db_functions_ctrl->update($table, $productDetailsUpd,$data);
        // echo $val;
        if($val>0)
            return "success";
        else
            return "failed";
        
    }
    
    public function deleteProduct(Request $request) {
        $values = $request->all();
        $product = MasterProducts::where('id',$values['id'])->get();
        $product = $product[0];        
        $img = $product['imagePath'];
        Storage::delete($img);
        // die();
        $status = \App\models\MasterProducts::withTrashed()
                ->where('id', $values['id'])
                ->delete();
        if($status>0)
            return "success";
        else
            return "failed";
    }

    public function addImages(Request $request) {
        $products = MasterProducts::where('id', $request['id'])->get();
        $catId = $products[0]['catId'];
        $subCatId = $products[0]['subCatId'];
        $path1 = $catId."/".$subCatId;
        $productImage = array();
        $len = 0;
        $cnt = 0;
        // if($request->hasfile('files'))
        //  {
            //  print_r($request->file('flies'));
            //  die();
            // foreach($request->file('flies') as $file)
            // {
            //     $fileName =$file->getClientOriginalName();
            //     $path = $file->storeAs(
            //         $path1,$fileName
            //     );
            //     $productImage['id'] = $request['id'];
            //     $productImage['imagePath'] = $path;
            //     $db_functions_ctrl = new DBFunctionsController();
            //     $table = "App\models\ProductImage";
            //     $val = $db_functions_ctrl->insert($table, $productData);
            //     if($val > 0) {
            //         $cnt++;
            //     }
            //     $len++;
            // }
            
        //  }
        //  if($len == $cnt)
        //     return "success";
        // return "failed";
        if($request->hasfile('files'))
         {
            foreach($request->file('files') as $key => $file)
            {
                $path = $file->storeAs($catId."/".$subCatId, $file->getClientOriginalName());
                // $name = $file->getClientOriginalName();
 
                $insert[$key]['productId'] = $request['id'];
                $insert[$key]['imagePath'] = $path;
                $insert[$key]['createdBy'] = Auth::user()->id;
 
            }
         }
 
        $val = ProductImage::insert($insert);
        if($val > 0) {
            return "success";
        }
        return "failed";
    }
    
    public function getImagesById(Request $request) {
        $values = $request->all();
        $productImages = ProductImage::where('productId', $values['id'])->get();
        return $productImages->toJSON();
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
    public function changeStatusProd(Request $request) {
        $values = $request->all();
        $productData = MasterProducts::where('id', $values['id'])->get();
        $productData = $productData[0];
        $product = array();
        $status = '';
        if($productData['status'] == 'ACTIVE') {
            $status = "IN-ACTIVE";
        }
        else {
            $status = "ACTIVE";
        }
        $product['status'] = $status;
        $db_functions_ctrl = new DBFunctionsController();
        $table = "App\models\MasterProducts";
        $data = array();
        $data['id'] = $values['id'];
        $val = $db_functions_ctrl->update($table, $product, $data);
        // die($val);
        if($val > 0) {
            return "success";
        }
        return "failed";
    }
}

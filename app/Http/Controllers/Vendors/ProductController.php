<?php

namespace App\Http\Controllers\Vendors;

use App\Http\Controllers\DBFunctions\DBFunctionsController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Models\Category;
use \App\Models\SubCategories;
use \App\Models\MasterProducts;
use \App\Models\ProductInventory;
use \App\Models\ProductInventoryOffers;
use Auth;
class ProductController extends Controller
{

    public function __construct(Request $request)
    {
    //  
        $this->middleware(['auth', 'role:vendor'], ['only' => ['addProductRequest', 'addProductRequest/{id}', 'getSubMasterCategoryByIdVendor', 'getProductDataByCatnSubVendor', 'viewProductRequest', 'updateProductRequest', 'viewProductOffers']]);

        
    }
    public function addProductRequestUpdate(Request $request, $id) {
        $categories = \App\Models\Category::all();
        // echo $id;
        // die();
        $requests = ProductInventory::where('id', $id)->get();
        // print_r($requests);
        // die();
        $products = MasterProducts::where('id', $requests[0]['productId'])->get(); 
        return view('vendor.products.addProductRequest', compact('categories', 'requests', 'products'));
    }
    public function addProductRequest(Request $request) {
        if($request->isMethod('get')) {
            $categories = \App\Models\Category::all();
            $requests = array();
            return view('vendor.products.addProductRequest', compact('categories', 'requests'));
        }
        if($request->isMethod('post')) {
            $values = $request->all();
            $productReq = array();
            $productReq['vendorId'] = Auth::user()->id;
            $productReq['productId'] = $values['productId'];
            $productReq['brandName'] = $values['brandName'];
            $productReq['quantity'] = $values['quantity'];
            $productReq['price'] = $values['price'];
            $productReq['mfd'] = $values['mfd'];
            $productReq['discount'] = $values['offerPrice'];
            $productReq['offerStartDate'] = date('Y-m-d', strtotime($values['startDate']));
            $productReq['offerEndDate'] = date('Y-m-d', strtotime($values['endDate']));
            if($values['expiry'] == '1') {
                $date = date('Y-m-d');
                $date = date('Y-m-d', strtotime("+12 months $date"));
                $productReq['expiry'] = $date;    
            }
            if($values['expiry'] == '2') {
                $date = date('Y-m-d');
                $date = date('Y-m-d', strtotime("+24 months $date"));
                $productReq['expiry'] = $date;    
            }
            if($values['expiry'] == '3') {
                $date = date('Y-m-d');
                $date = date('Y-m-d', strtotime("+36 months $date"));
                $productReq['expiry'] = $date;    
            }
            $db_functions_ctrl = new DBFunctionsController();
            $table = "App\models\ProductInventory";
            $val = $db_functions_ctrl->insert($table, $productReq);
        
            if($val>0)
                return "success";
            else
                return "failed";
        }
    }
    public function updateProductRequest(Request $request) {
        $values = $request->all();
        $productReq = array();
        $productReq['vendorId'] = Auth::user()->id;
        $productReq['productId'] = $values['productId'];
        $productReq['brandName'] = $values['brandName'];
        $productReq['quantity'] = $values['quantity'];
        $productReq['price'] = $values['price'];
        $productReq['mfd'] = $values['mfd'];
        $productReq['discount'] = $values['offerPrice'];
        $productReq['offerStartDate'] = date('Y-m-d', strtotime($values['startDate']));
        $productReq['offerEndDate'] = date('Y-m-d', strtotime($values['endDate']));
        if($values['expiry'] == '1') {
            $date = date('Y-m-d');
            $date = date('Y-m-d', strtotime("+12 months $date"));
            $productReq['expiry'] = $date;    
        }
        if($values['expiry'] == '2') {
            $date = date('Y-m-d');
            $date = date('Y-m-d', strtotime("+24 months $date"));
            $productReq['expiry'] = $date;    
        }
        if($values['expiry'] == '3') {
            $date = date('Y-m-d');
            $date = date('Y-m-d', strtotime("+36 months $date"));
            $productReq['expiry'] = $date;    
        }
        $db_functions_ctrl = new DBFunctionsController();
        $data = array();
        $data['id'] = $values['id'];
        $table = "App\models\ProductInventory";
        $val = $db_functions_ctrl->update($table, $productReq, $data);
    
        if($val>0)
            return "success";
        else
            return "failed";
    }

    public function viewProductRequest() {
        $requests = ProductInventory::where('productInventory.createdBy', Auth::user()->id)->leftjoin('masterproducts', 'masterproducts.id', '=', 'productinventory.productId')->leftjoin('categories', 'masterproducts.catId','=','categories.id')->leftjoin('subcategories', 'masterproducts.subCatId','=','subcategories.id')->select('masterproducts.productName', 'productinventory.brandName', 'productinventory.price', 'productinventory.status', 'productinventory.quantity','productinventory.id', 'categories.categoryName', 'subcategories.subCategoryName','productinventory.expiry', 'productinventory.discount', 'productinventory.offerStartDate', 'productinventory.offerEndDate')->get();
        return view('vendor.products.viewProductRequest', compact('requests'));
    }

    public function getSubMasterCategoryByIdVendor(Request $request) {
        $values = $request->all();
        $subCategories = SubCategories::where('catId', $values['id'])->get();
        return $subCategories->toJson();
    }

    public function getProductDataByCatnSubVendor(Request $request) {
        $values = $request->all();
        $productData = MasterProducts::select('masterproducts.imagePath','masterproducts.id','masterproducts.catId','masterproducts.subCatId','masterproducts.productName','categories.categoryName', 'subcategories.subCategoryName', 'masterproducts.description','masterproducts.status')->join('categories', 'masterproducts.catId','=','categories.id')->join('subcategories', 'masterproducts.subCatId','=','subcategories.id')->orderBy('masterproducts.id')->where('masterproducts.catId',$values['catId'])->where('masterproducts.subCatId',$values['subCatId'])->get();
        // echo $productData;
        return $productData->toJson(); 
    }

    public function deleteProductRequest(Request $request) {
        $values = $request->all();
        $status = ProductInventory::withTrashed()
                ->where('id', $values['id'])
                ->delete();
        if($status>0)
            return "success";
        else
            return "failed";
    }

    // public function viewProductOffers() {
    //     $offers = ProductInventoryOffers::leftjoin('masterproducts', 'masterproducts.id', 'productinventoryoffers.productId')->leftjoin('categories', 'categories.id', '=', 'masterproducts.catId')->leftjoin('subcategories', 'subcategories.id', '=', 'masterproducts.catId')->select('masterproducts.productName', 'masterproducts.brandName', 'categories.categoryName', 'subcategories.subCategoryName', 'productinventoryoffers.offer', 'productinventoryoffers.startDate', 'productinventoryoffers.endDate','productinventory.price')->get();
    //     return view("vendor.products.viewOffers", compact('offers'));
    // }
}

<?php

use Illuminate\Support\Facades\Route;
// use Auth;


require __DIR__.'/auth.php';
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'App\Http\Controllers\Admin\DashboardController@display')->middleware('auth');
Route::get('dashboard', 'App\Http\Controllers\Admin\DashboardController@display')->middleware('auth');

// Route::get('dashboard', function() {
//          return view('dashboard');
//     })->middleware('auth');

Route::group(['middleware'=>['auth','role:superadministrator']], function ()
{
    // echo "hi";
    // die();

//     Route::get('dashboard', function() {
//         return view('dashboard');
//    });
//     Route::get('/', function() {
//         return view('dashboard');
//     });

    

    Route::post('addCategory', [App\Http\Controllers\Admin\CategoryController::class,'insert'])->name('addCategory');
    Route::get('viewCategory', [App\Http\Controllers\Admin\CategoryController::class,'display'])->name('view-Category');
    Route::post('getMasterCategoryById', [App\Http\Controllers\Admin\CategoryController::class,'getMasterCategoryById'])->name('getMasterCategoryById');
    Route::post('updateCategory', 'App\Http\Controllers\Admin\CategoryController@updateCategory');
    Route::post('deleteCategory', 'App\Http\Controllers\Admin\CategoryController@deleteCategory');
    Route::post('changeStatusCat', 'App\Http\Controllers\Admin\CategoryController@changeStatusCat');
    
    
    

    //Sub Cats
    Route::get('viewSubCategory', 'App\Http\Controllers\Admin\SubCategoryController@display');
    Route::post('addSubCat', 'App\Http\Controllers\Admin\SubCategoryController@insert');
    Route::post('getSubMasterCategoryById', 'App\Http\Controllers\Admin\SubCategoryController@getSubMasterCategoryById');
    Route::post('updateSubCat', 'App\Http\Controllers\Admin\SubCategoryController@updateSubCat');
    Route::post('deleteSubCategory', 'App\Http\Controllers\Admin\SubCategoryController@deleteSubCategory');
    Route::post('changeStatusSubCat', 'App\Http\Controllers\Admin\SubCategoryController@changeStatusSubCat');
    Route::post('getSubMasterCategoryByCatId', 'App\Http\Controllers\Admin\SubCategoryController@getSubMasterCategoryByCatId');

    //Products
    Route::get('viewProduct', 'App\Http\Controllers\Admin\ProductController@viewProduct');
    Route::get('addProduct', 'App\Http\Controllers\Admin\ProductController@addProduct');
    Route::post('addImages', 'App\Http\Controllers\Admin\ProductController@addImages');
    Route::post('getImagesById', 'App\Http\Controllers\Admin\ProductController@getImagesById');
    

    Route::post('saveProduct', 'App\Http\Controllers\Admin\ProductController@saveProduct');
    Route::post('getProductById', 'App\Http\Controllers\Admin\ProductController@getProductById');
    Route::get('updateProduct/{id}', 'App\Http\Controllers\Admin\ProductController@updateProduct');
    Route::post('updateProductData', 'App\Http\Controllers\Admin\ProductController@updateProductData');
    Route::post('deleteProduct', 'App\Http\Controllers\Admin\ProductController@deleteProduct');
    Route::post('changeStatusProd', 'App\Http\Controllers\Admin\ProductController@changeStatusProd');

    //vendors
    // Route::get('addVendor', [App\Http\Controllers\Admin\VendorController::class,'insert'])->name('addVendor');
    Route::get('/addVendor', 'App\Http\Controllers\Admin\VendorController@insert');
    Route::post('/addVendor', 'App\Http\Controllers\Admin\VendorController@insert');
    Route::post('/checkGst', 'App\Http\Controllers\Admin\VendorController@checkGst');
    Route::post('/updateVendor', 'App\Http\Controllers\Admin\VendorController@updateVendor');
    Route::post('/deleteVendor', 'App\Http\Controllers\Admin\VendorController@deleteVendor');
    Route::post('/changeStatus', 'App\Http\Controllers\Admin\VendorController@changeStatus');
    

    Route::post('/getVendorStatus', 'App\Http\Controllers\Admin\VendorController@getVendorStatus');
    

    Route::get('/viewVendor', 'App\Http\Controllers\Admin\VendorController@viewVendor');
    
    Route::post('/getGstDetails', 'App\Http\Controllers\Admin\VendorController@getGstDetails');
    Route::post('/sendOtp', 'App\Http\Controllers\API\APIController@sendOtp');
    Route::post('/verifyCode', 'App\Http\Controllers\API\APIController@verifyCode');

    Route::post('/checkEmail', 'App\Http\Controllers\Admin\VendorController@checkEmail');
    Route::post('/checkMobile', 'App\Http\Controllers\Admin\VendorController@checkMobile');
    

    //Admins
    Route::get('/addAdmin', 'App\Http\Controllers\Admin\AdminController@addAdmin');
    Route::post('/addRepresntative', 'App\Http\Controllers\Admin\AdminController@addAdmin');
    Route::get('/viewAdmin', 'App\Http\Controllers\Admin\AdminController@display');
    
    
    //Role Permissions

    Route::get('/viewPermission', 'App\Http\Controllers\Admin\PermissionController@viewPermission');
    Route::post('/savePermission', 'App\Http\Controllers\Admin\PermissionController@savePermission');
    Route::post('/updatePermission', 'App\Http\Controllers\Admin\PermissionController@updatePermission');
    Route::post('/getPermission', 'App\Http\Controllers\Admin\PermissionController@getPermission');
    
    Route::post('/deletePermission', 'App\Http\Controllers\Admin\PermissionController@deletePermission');
    Route::get('/assignPermission', 'App\Http\Controllers\Admin\PermissionController@assignPermission');
    Route::post('/getPermissionByRoleId', 'App\Http\Controllers\Admin\PermissionController@getPermissionByRoleId');
    Route::post('/getNotAssignedPermissionByRoleId', 'App\Http\Controllers\Admin\PermissionController@getNotAssignedPermissionByRoleId');
    Route::post('/updatePermissions', 'App\Http\Controllers\Admin\PermissionController@updatePermissions');
    

    //Roles

    Route::get('/viewRole', 'App\Http\Controllers\Admin\RoleController@viewRole');
    Route::post('/saveRole', 'App\Http\Controllers\Admin\RoleController@saveRole');
    Route::post('/updateRole', 'App\Http\Controllers\Admin\RoleController@updateRole');
    Route::post('/getRole', 'App\Http\Controllers\Admin\RoleController@getRole');    
    Route::post('/deleteRole', 'App\Http\Controllers\Admin\RoleController@deleteRole');


    //sliders
    Route::get('/viewSlider', 'App\Http\Controllers\Admin\SliderController@display');
    Route::post('/saveSlider', 'App\Http\Controllers\Admin\SliderController@insert');
    Route::post('/getSliderById', 'App\Http\Controllers\Admin\SliderController@getSliderById');
    Route::post('/updateSlider', 'App\Http\Controllers\Admin\SliderController@updateSlider');
    Route::post('/deleteSlider', 'App\Http\Controllers\Admin\SliderController@deleteSlider');
    Route::post('/changeStatusSlide', 'App\Http\Controllers\Admin\SliderController@changeStatusSlide');
    
    
});

//vendor routes
Route::group(['middleware'=>['auth','role:vendor']], function ()
{
    Route::get('/addProductRequest', 'App\Http\Controllers\Vendors\ProductController@addProductRequest');
    Route::get('/addProductRequest/{id}', 'App\Http\Controllers\Vendors\ProductController@addProductRequestUpdate');
    Route::post('getSubMasterCategoryByIdVendor', 'App\Http\Controllers\Vendors\ProductController@getSubMasterCategoryByIdVendor');
    Route::post('getProductDataByCatnSubVendor', 'App\Http\Controllers\Vendors\ProductController@getProductDataByCatnSubVendor');
    Route::post('/addProductRequest', 'App\Http\Controllers\Vendors\ProductController@addProductRequest');
    Route::post('/updateProductRequest', 'App\Http\Controllers\Vendors\ProductController@updateProductRequest');
    Route::get('/viewProductRequest', 'App\Http\Controllers\Vendors\ProductController@viewProductRequest');
    Route::post('/deleteProductRequest', 'App\Http\Controllers\Vendors\ProductController@deleteProductRequest');

    Route::get('/viewProductOffers', 'App\Http\Controllers\Vendors\ProductController@viewProductOffers');

    
    // Route::post('getSubMasterCategoryByIdVendor', 'App\Http\Controllers\Vendor\ProductController@getSubMasterCategoryByIdVendor');
});


Route::get('changePassword', function() {
    return view('changePassword');
})->middleware(['auth', 'role:vendor|administrator|superadministrator']);
Route::post('/changePassword', 'App\Http\Controllers\Users\ProfileController@changePassword')->middleware(['auth', 'role:vendor|administrator|superadministrator']);

Route::get('lockscreen', function() {
    return view('lockscreen');
})->middleware(['auth', 'role:vendor|administrator|superadministrator']);
Route::post('/unLock', 'App\Http\Controllers\Users\ProfileController@unLock')->middleware(['auth', 'role:vendor|administrator|superadministrator']);


// Route::get('/addProductRequest', 'App\Http\Controllers\Vendors\ProductController@addProductRequest')->middleware(['auth', 'role:vendor']);
// Route::get('/addProductRequest/{id}', 'App\Http\Controllers\Vendors\ProductController@addProductRequestUpdate')->middleware(['auth', 'role:vendor']);
// Route::post('getSubMasterCategoryByIdVendor', 'App\Http\Controllers\Vendors\ProductController@getSubMasterCategoryByIdVendor')->middleware(['auth', 'role:vendor']);
// Route::post('getProductDataByCatnSubVendor', 'App\Http\Controllers\Vendors\ProductController@getProductDataByCatnSubVendor')->middleware(['auth', 'role:vendor']);
// Route::post('/addProductRequest', 'App\Http\Controllers\Vendors\ProductController@addProductRequest')->middleware(['auth', 'role:vendor']);
// Route::post('/updateProductRequest', 'App\Http\Controllers\Vendors\ProductController@updateProductRequest')->middleware(['auth', 'role:vendor']);
// Route::get('/viewProductRequest', 'App\Http\Controllers\Vendors\ProductController@viewProductRequest')->middleware(['auth', 'role:vendor']);
// Route::post('/deleteProductRequest', 'App\Http\Controllers\Vendors\ProductController@deleteProductRequest')->middleware(['auth', 'role:vendor']);

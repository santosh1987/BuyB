<?php

use Illuminate\Support\Facades\Route;


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

Route::get('/', function () {
    return view('dashboard');
})->middleware('auth');


// Route::get('dashboard', function() {
//          return view('dashboard');
//     })->middleware('auth');

Route::group(['middleware'=>['auth','role:superadministrator']], function ()
{
    

    Route::get('dashboard', function() {
        return view('dashboard');
   });

    

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
    Route::post('saveProduct', 'App\Http\Controllers\Admin\ProductController@saveProduct');
    Route::post('getProductById', 'App\Http\Controllers\Admin\ProductController@getProductById');
    Route::post('updateProduct', 'App\Http\Controllers\Admin\ProductController@updateProduct');
    Route::post('deleteProduct', 'App\Http\Controllers\Admin\ProductController@deleteProduct');
    Route::post('changeProductStatus', 'App\Http\Controllers\Admin\ProductController@changeProductStatus');

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
    
    //Role Permissions

    Route::get('/viewPermission', 'App\Http\Controllers\Admin\PermissionController@viewPermission');
    Route::post('/savePermission', 'App\Http\Controllers\Admin\PermissionController@savePermission');
    Route::post('/updatePermission', 'App\Http\Controllers\Admin\PermissionController@updatePermission');
    Route::post('/getPermission', 'App\Http\Controllers\Admin\PermissionController@getPermission');
    
    Route::post('/deletePermission', 'App\Http\Controllers\Admin\PermissionController@deletePermission');


    //Roles

    Route::get('/viewRole', 'App\Http\Controllers\Admin\RoleController@viewRole');
    Route::post('/saveRole', 'App\Http\Controllers\Admin\RoleController@saveRole');
    Route::post('/updateRole', 'App\Http\Controllers\Admin\RoleController@updateRole');
    Route::post('/getRole', 'App\Http\Controllers\Admin\RoleController@getRole');
    
    Route::post('/deleteRole', 'App\Http\Controllers\Admin\RoleController@deleteRole');
});

//administrator routes
Route::group(['middleware'=>['auth','role:administrator']], function ()
{
    // Route::get('dashboard', function() {
    //      return view('dashboard');
    // });
});

// vendor routes
Route::group(['middleware'=>['auth', 'role:vendor']], function ()
{
    // Route::get('dashboard', function() {
    //      return view('dashboard');
    // });
});



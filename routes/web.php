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
    // Route::get('dashboard', function() {
    //      return view('dashboard');
    // });

    // Route::get('/viewCategory', function() {
    //     return view('Admin.categories.viewCategories');
    // });

    Route::get('dashboard', function() {
        return view('dashboard');
   });

    Route::get('/viewSubCategory', function() {
        return view('Admin.categories.viewSubCategories');
    });

    Route::post('addCategory', [App\Http\Controllers\Admin\CategoryController::class,'insert'])->name('addCategory');
    Route::get('viewCategory', [App\Http\Controllers\Admin\CategoryController::class,'display'])->name('view-Category');
    Route::post('getMasterCategoryById', [App\Http\Controllers\Admin\CategoryController::class,'getMasterCategoryById'])->name('getMasterCategoryById');
    

    // Route::get('addVendor', [App\Http\Controllers\Admin\VendorController::class,'insert'])->name('addVendor');
    Route::get('/addVendor', 'App\Http\Controllers\Admin\VendorController@insert');
    Route::post('/addVendor', 'App\Http\Controllers\Admin\VendorController@insert');
    Route::post('/checkGst', 'App\Http\Controllers\Admin\VendorController@checkGst');
    
    Route::post('/getGstDetails', 'App\Http\Controllers\Admin\VendorController@getGstDetails');
    Route::post('/sendOtp', 'App\Http\Controllers\API\APIController@sendOtp');
    Route::post('/verifyCode', 'App\Http\Controllers\API\APIController@verifyCode');

    Route::post('/checkEmail', 'App\Http\Controllers\Admin\VendorController@checkEmail');
    Route::post('/checkMobile', 'App\Http\Controllers\Admin\VendorController@checkMobile');
    
    

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



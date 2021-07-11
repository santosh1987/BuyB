<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::group(['middleware'=>['auth','role:superadministrator']], function ()
{
    Route::get('Adashboard', function() {
         return view('Admin.Adashboard');
    });

    // Route::get('/view-Category', function() {
    //     return view('Admin.categories.viewCategories');
    // });

    Route::get('/view-SubCategory', function() {
        return view('Admin.categories.viewSubCategories');
    });

    Route::post('addCategory', [App\Http\Controllers\Admin\CategoryController::class,'insert'])->name('addCategory');
    Route::get('view-Category', [App\Http\Controllers\Admin\CategoryController::class,'display'])->name('view-Category');

});

//administrator routes
Route::group(['middleware'=>['auth','role:administrator']], function ()
{
    Route::get('dashboard', function() {
         return view('Vendor.Vdashboard');
    });
});

// vendor routes
Route::group(['middleware'=>['auth']], function ()
{
    Route::get('vdashboard', function() {
         return view('dashboard');
    });
});

require __DIR__.'/auth.php';

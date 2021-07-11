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

// super administrator routes

Route::group(['middleware'=>['auth']], function ()
{
    Route::get('dashboard', function() {
         return view('Admin.Adashboard');
    });
});

//administrator routes
Route::group(['middleware'=>['auth']], function ()
{
    Route::get('tdashboard', function() {
         return view('dashboard');
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

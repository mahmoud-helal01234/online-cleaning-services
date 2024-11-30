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

Route::group(['middleware' => [], 'namespace' => 'App\Http\Controllers'], function () {
    
    Route::get('/', 'WebsitePagesController@homePage');

});


// Route::get('/what-we-do', function () {
    
//     return view('what-we-do');

// });

Route::get('lang/{locale}', function ($locale) {
    if (!in_array($locale, ['en', 'ar'])) {
        abort(400);
    }
    
    session(['locale' => $locale]);
    return redirect()->back();
});


<?php
use Illuminate\Support\Facades\Route;
// Route::group([
//     'prefix'=>'admin', 
//     'namespace'=>'App\Http\Controllers\Admin', 
//     'middleware'=>['web']
// ], function(){
//     Route::get('/', 'Auth\LoginController@showLoginForm')->name('admin.login');
//     Route::post('/', 'Auth\LoginController@validateLogin')->name('admin.login.submit');
//     Route::group(['middleware' => ['auth:admin']], function () {
//         Route::post('/logout', 'Auth\LoginController@logout')->name('admin.logout');
//         Route::group(['prefix' => 'dashboard'], function () {
//             Route::get('/', 'DashboardController@index')->name('admin.dashboard');
//         });
//     });
// });


Route::prefix('rubi')->namespace('App\Http\Controllers\Rubi')->middleware(['web'])->group(function () {
    
    Route::get('/', 'Auth\LoginController@showLoginForm')->name('rubi.login');
    Route::post('/', 'Auth\LoginController@validateLogin')->name('rubi.login.submit');
    
    Route::middleware(['auth:rubiAdmin'])->group(function () { //if Rubi's admin is logged in
        
        Route::post('/logout', 'Auth\LoginController@logout')->name('rubi.logout');
        
        Route::prefix('dashboard')->middleware(['auth:rubiAdmin'])->group(function () { //Rubi dashboard routes

            Route::get('/', 'PathController@dashboard')->name('rubi.dashboard');

        });
    });
});
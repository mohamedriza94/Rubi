<?php
use Illuminate\Support\Facades\Route;

Route::prefix('businessAdmin')->namespace('App\Http\Controllers\Sub')->middleware(['web'])->group(function () {
    
    Route::get('/', 'Auth\LoginController@showLoginForm')->name('sub.login');
    Route::post('/', 'Auth\LoginController@validateLogin')->name('sub.login.submit');
    
    Route::middleware(['auth:business'])->group(function () { //if business's admin is logged in
        
        Route::post('/logout', 'Auth\LoginController@logout')->name('sub.logout');
        
        Route::prefix('dashboard')->middleware(['auth:businessAdmin'])->group(function () { //Rubi dashboard routes

            //page routes
            Route::get('/', 'PathController@dashboard')->name('sub.dashboard');
        });
    });
}); 
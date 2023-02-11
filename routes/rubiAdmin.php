<?php
use Illuminate\Support\Facades\Route;

Route::prefix('rubi')->namespace('App\Http\Controllers\Rubi')->middleware(['web'])->group(function () {
    
    Route::get('/', 'Auth\LoginController@showLoginForm')->name('rubi.login');
    Route::post('/', 'Auth\LoginController@validateLogin')->name('rubi.login.submit');
    
    Route::middleware(['auth:rubiAdmin'])->group(function () { //if Rubi's admin is logged in
        
        Route::post('/logout', 'Auth\LoginController@logout')->name('rubi.logout');
        
        Route::prefix('dashboard')->middleware(['auth:rubiAdmin'])->group(function () { //Rubi dashboard routes

            Route::get('/', 'PathController@dashboard')->name('rubi.dashboard');
            Route::get('/messages', 'PathController@messages')->name('rubi.messages');

            //messages
            Route::get('/readMessages/{type}/{limit}', 'MessageController@readMessages');
            Route::get('/starMessage/{id}/{status}', 'MessageController@starMessage');

            
        });
    });
});
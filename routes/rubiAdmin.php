<?php
use Illuminate\Support\Facades\Route;

Route::prefix('rubi')->namespace('App\Http\Controllers\Rubi')->middleware(['web'])->group(function () {
    
    Route::get('/', 'Auth\LoginController@showLoginForm')->name('rubi.login');
    Route::post('/', 'Auth\LoginController@validateLogin')->name('rubi.login.submit');
    
    Route::middleware(['auth:rubiAdmin'])->group(function () { //if Rubi's admin is logged in
        
        Route::post('/logout', 'Auth\LoginController@logout')->name('rubi.logout');
        
        Route::prefix('dashboard')->middleware(['auth:rubiAdmin'])->group(function () { //Rubi dashboard routes

            //page routes
            Route::get('/', 'PathController@dashboard')->name('rubi.dashboard');
            Route::get('/messages', 'PathController@messages')->name('rubi.messages');
            Route::get('/packages', 'PathController@packages')->name('rubi.packages');
            Route::get('/activity', 'PathController@activity')->name('rubi.activity');
            Route::get('/business', 'PathController@business')->name('rubi.business');
            
            //messages
            Route::get('/readMessages/{type}/{limit}', 'MessageController@readMessages');
            Route::get('/starMessage/{id}/{status}', 'MessageController@starMessage');
            Route::put('/moveToTrash/{type}', 'MessageController@moveToTrash');
            Route::post('/sendMessage', 'MessageController@sendMessage');
            Route::get('/seeMessage/{id}/{type}', 'MessageController@seeMessage');
            Route::post('/sendReply', 'MessageController@sendReply');
            Route::get('/searchMessages/{search}/{limit}', 'MessageController@searchMessages');

            //packages
            Route::get('/readPackage/{limit}', 'PackageController@read');
            Route::post('/createPackage', 'PackageController@create');
            Route::post('/updatePackage', 'PackageController@update');
            Route::put('/deletePackage', 'PackageController@delete');
            Route::get('/readOnePackage/{id}', 'PackageController@readOne');
            Route::put('/updatePackageStatus', 'PackageController@updateStatus');

            //activities
            Route::get('/readActivities/{limit}', 'ActivityController@read');
            Route::get('/searchActivities/{search}/{limit}', 'ActivityController@search');

            //businesses
            Route::get('/readBusinesses/{limit}/{status}', 'BusinessController@read');
            Route::get('/searchBusinesses/{search}/{limit}/{status}', 'BusinessController@search');
            Route::get('/readOneBusiness/{id}', 'BusinessController@readOne');
            Route::put('/updateBusinessStatus', 'BusinessController@updateStatus');

            //dashboard
            Route::get('/count', 'DashboardController@readCount');

            //notification
            Route::get('/notification', 'DashboardController@notification');
        });
    });
});
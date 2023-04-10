<?php
use Illuminate\Support\Facades\Route;

Route::prefix('business')->namespace('App\Http\Controllers\Business')->middleware(['web'])->group(function () {
    
    Route::get('/', 'Auth\LoginController@showLoginForm')->name('business.login');
    Route::post('/', 'Auth\LoginController@validateLogin')->name('business.login.submit');
    
    Route::middleware(['auth:business'])->group(function () { //if business's admin is logged in
        
        Route::post('/logout', 'Auth\LoginController@logout')->name('business.logout');
        
        Route::prefix('dashboard')->middleware(['auth:business'])->group(function () { //Rubi dashboard routes

            //page routes
            Route::get('/', 'PathController@dashboard')->name('business.dashboard');
            Route::get('/departments', 'PathController@departments')->name('business.departments');
            Route::get('/admins', 'PathController@admins')->name('business.admins');
            Route::get('/activities', 'PathController@activities')->name('business.activities');
            Route::get('/cashOutFlow', 'PathController@cashOutFlow')->name('business.cashOutFlow');
            Route::get('/messages', 'PathController@messages')->name('business.messages');

            //departments
            Route::get('/readDepartments', 'DepartmentsController@read');
            Route::get('/readActiveDepartments', 'DepartmentsController@readActive');
            Route::post('/createDepartment', 'DepartmentsController@create');
            Route::get('/readOneDepartment/{id}', 'DepartmentsController@readOne');
            Route::put('/updateDepartmentStatus', 'DepartmentsController@updateStatus');

            //business admins
            Route::get('/readBusinessAdmins', 'BusinessAdminController@read');
            Route::post('/createBusinessAdmin', 'BusinessAdminController@create');
            Route::get('/readOneBusinessAdmin/{id}', 'BusinessAdminController@readOne');
            Route::put('/updateBusinessAdminStatus', 'BusinessAdminController@updateStatus');
            Route::post('/updateBusinessAdmin', 'BusinessAdminController@update');
            Route::post('/updateBusinessAdminProfilePicture', 'BusinessAdminController@updateProfilePicture');
            Route::put('/deleteBusinessAdmin', 'BusinessAdminController@delete');
        });
    });
});
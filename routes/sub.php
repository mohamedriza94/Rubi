<?php
use Illuminate\Support\Facades\Route;

Route::prefix('sub')->namespace('App\Http\Controllers\Sub')->middleware(['web'])->group(function () {
    
    Route::get('/', 'Auth\LoginController@showLoginForm')->name('sub.login');
    Route::post('/', 'Auth\LoginController@validateLogin')->name('sub.login.submit');
    
    Route::middleware(['auth:business'])->group(function () { //if business's admin is logged in
        
        Route::post('/logout', 'Auth\LoginController@logout')->name('sub.logout');
        
        Route::prefix('dashboard')->middleware(['auth:businessAdmin'])->group(function () { //Rubi dashboard routes

            //page routes
            Route::get('/', 'PathController@dashboard')->name('sub.dashboard');
            Route::get('/tasks', 'PathController@tasks')->name('sub.tasks');
            Route::get('/activities', 'PathController@activities')->name('sub.activities');
            Route::get('/notes', 'PathController@notes')->name('sub.notes');
            Route::get('/pettyExpense', 'PathController@pettyExpense')->name('sub.pettyExpense');
            Route::get('/attendance', 'PathController@attendance')->name('sub.attendance');
            Route::get('/payroll', 'PathController@payroll')->name('sub.payroll');
            Route::get('/employees', 'PathController@employees')->name('sub.employees');
            Route::get('/pettyExpenseReport', 'PathController@pettyExpenseReport')->name('sub.pettyExpenseReport');

            //tasks
            Route::get('/readTasks', 'TaskController@read');
            Route::post('/createTask', 'TaskController@create');
            Route::get('/readOneTask/{id}', 'TaskController@readOne');
            Route::put('/startOrEndTask', 'TaskController@updateStatus');
            Route::get('/readTopTask', 'TaskController@readTop');
        });
    });
}); 
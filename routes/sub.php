<?php
use Illuminate\Support\Facades\Route;

Route::prefix('sub')->namespace('App\Http\Controllers\Sub')->middleware(['web'])->group(function () {
    
    Route::get('/', 'Auth\LoginController@showLoginForm')->name('sub.login');
    Route::post('/', 'Auth\LoginController@validateLogin')->name('sub.login.submit');
    
    Route::middleware(['auth:businessAdmin'])->group(function () { //if business's admin is logged in
        
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
            Route::get('/vacancies', 'PathController@vacancies')->name('sub.vacancies');
            Route::get('/applications', 'PathController@applications')->name('sub.applications');
            Route::get('/pettyExpenseReport', 'PathController@pettyExpenseReport')->name('sub.pettyExpenseReport');

            //tasks
            Route::get('/readTasks', 'TaskController@read');
            Route::post('/createTask', 'TaskController@create');
            Route::get('/readOneTask/{id}', 'TaskController@readOne');
            Route::put('/startOrEndTask', 'TaskController@updateStatus');
            Route::get('/readTopTask', 'TaskController@readTop');

            //change password
            Route::put('/changePassword','commonController@changePassword');

            //statistics
            Route::get('/readStatistics', 'commonController@statistics');

            //notes
            Route::post('/createNote', 'NoteController@create');
            Route::get('/readNotes', 'NoteController@read');

            //petty expenses
            Route::post('/recordExpense', 'NoteController@create');
            Route::get('/readExpenses', 'NoteController@read');

            //attendance
            Route::get('/readAttendance', 'AttendanceController@read');

            //vacancies
            Route::post('/createVacancy', 'VacancyController@create');
            Route::put('/updateVacancyStatus', 'VacancyController@updateStatus');
            Route::post('/updateVacancy', 'VacancyController@update');
            Route::get('/readVacancies', 'VacancyController@read');
            Route::get('/readOneVacancy/{id}', 'VacancyController@readOne');

            //applications
            Route::get('/searchApplication/{search}', 'ApplicationController@search');
            Route::get('/readApplication/{type}', 'ApplicationController@sort');
            Route::get('/readApplication', 'ApplicationController@read');
            Route::get('/readOneApplication/{id}', 'ApplicationController@readOne');
            Route::put('/shortlistApplication', 'ApplicationController@shortlist');
            Route::put('/rejectApplication', 'ApplicationController@reject');
        });
    });
}); 
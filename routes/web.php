<?php

use Illuminate\Support\Facades\Route;

//page routes
Route::get('/', [App\Http\Controllers\public\pathController::class, 'home'])->name('client.home');
Route::get('/careers', [App\Http\Controllers\public\pathController::class, 'careers'])->name('client.careers');
Route::get('/contact', [App\Http\Controllers\public\pathController::class, 'contact'])->name('client.contact');
Route::get('/about', [App\Http\Controllers\public\pathController::class, 'about'])->name('client.about');
Route::get('/signin', [App\Http\Controllers\public\pathController::class, 'signin'])->name('client.signin');
Route::get('/registration', [App\Http\Controllers\public\pathController::class, 'registration'])->name('client.registration');
Route::get('/Forgot+Password', [App\Http\Controllers\public\pathController::class, 'forgotPassword'])->name('client.forgotPassword');
Route::get('/Job+Details', [App\Http\Controllers\public\pathController::class, 'jobDetails'])->name('client.jobDetails');
Route::get('/Registration+step+two', [App\Http\Controllers\public\pathController::class, 'registrationStepTwo'])->name('client.registrationStepTwo');

//post routes
Route::post('/contactPOST', [App\Http\Controllers\public\ContactController::class, 'contactPOST'])->name('contactPOST');

<?php
namespace App\Http\Controllers\public;
use Illuminate\Support\Facades\Route;

//page routes
Route::get('/', [pathController::class, 'home'])->name('client.home');
Route::get('/careers', [pathController::class, 'careers'])->name('client.careers');
Route::get('/contact', [pathController::class, 'contact'])->name('client.contact');
Route::get('/about', [pathController::class, 'about'])->name('client.about');
Route::get('/signin', [pathController::class, 'signin'])->name('client.signin');
Route::get('/registration', [pathController::class, 'registration'])->name('client.registration');
Route::get('/Forgot+Password', [pathController::class, 'forgotPassword'])->name('client.forgotPassword');
Route::get('/Job+Details', [pathController::class, 'jobDetails'])->name('client.jobDetails');
Route::get('/Registration+step+two', [pathController::class, 'registrationStepTwo'])->name('client.registrationStepTwo');

//post routes
Route::post('/contactPOST', [ContactController::class, 'contactPOST'])->name('contactPOST');
Route::post('/newsLetterSubscribe', [NewsLetterController::class, 'newsLetterSubscribe'])->name('newsLetterSubscribe');
Route::post('/registrationPOST', [BusinessController::class, 'registrationPOST'])->name('registrationPOST');

//verification routes
Route::get('/verifyBusiness/{businessNo}', [BusinessController::class, 'verifyBusiness'])->name('verifyBusiness');
Route::post('/verifyEmailAndSendOTP', [BusinessController::class, 'verifyEmailAndSendOTP'])->name('verifyEmailAndSendOTP');
Route::get('resetPassword/{title}/{email}', function ($title, $email) {return view('client.resetPassword',['title' => $title, 'email' => $email, ]);})->name('client.resetPassword');
Route::post('/resetPassword', [BusinessController::class, 'resetPassword'])->name('resetPassword');
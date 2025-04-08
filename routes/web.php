<?php

use Illuminate\Support\Facades\Route;
use App\Mail\Newsletter;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\NewsletterController;

Route::get('/newsletter', function () {

    Mail::to("nesterenka.makar@gmail.com")->send( new Newsletter() );

    echo "mail sent";
});

Route::get('/', [NewsletterController::class, 'showSignupForm'])->name('signup.form');
Route::post('/', [NewsletterController::class, 'processSignup'])->name('signup.process');
Route::get('/unsubscribe', [NewsletterController::class, 'unsubscribe'])->name('unsubscribe');


Route::get('/reload-captcha', function () {
    return response()->json(['captcha' => captcha_src()]);
})->name('reload.captcha');
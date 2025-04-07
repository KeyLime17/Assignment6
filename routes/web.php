<?php

use Illuminate\Support\Facades\Route;
use App\Mail\Newsletter;
use Illuminate\Support\Facades\Mail;

Route::get('/newsletter', function () {

    Mail::to("nesterenka.makar@gmail.com")->send( new Newsletter() );

    echo "mail sent";
});

Route::get('/signup', [NewsletterController::class, 'showSignupForm'])->name('signup.form');
Route::post('/signup', [NewsletterController::class, 'processSignup'])->name('signup.process');

Route::get('/reload-captcha', function () {
    return response()->json(['captcha' => captcha_src()]);
})->name('reload.captcha');
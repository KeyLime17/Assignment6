<?php

use Illuminate\Support\Facades\Route;
use App\Mail\Newsletter;
use Illuminate\Support\Facades\Mail;

Route::get('/newsletter', function () {

    Mail::to("nesterenka.makar@gmail.com")->send( new Newsletter() );

    echo "mail sent";
});
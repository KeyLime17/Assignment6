<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Console\ClosureCommand;
use Illuminate\Support\Facades\Schedule;
use App\Mail\Newsletter;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;

Schedule::call(function () {

    $response = Http::get('https://api.coinlore.net/api/ticker/?id=90');
    $alltickers = Http::get('https://api.coinlore.net/api/tickers/');

    $data["symbol"] = $response->json()[0]['symbol'];
    $data["price_usd"] = $response->json()[0]['price_usd'];
    $data["percent_change_24h"] = $response->json()[0]['percent_change_24h'];
    $data["percent_change_1h"] = $response->json()[0]['percent_change_1h'];
    $data["alltickers"] = $alltickers->json()['data'];

    Mail::to("nesterenka.makar@gmail.com")->send( new Newsletter($data) );
})->everyMinute();
    

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

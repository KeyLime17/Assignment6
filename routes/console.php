<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Console\ClosureCommand;
use Illuminate\Support\Facades\Schedule;
use App\Mail\Newsletter;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use App\Models\Subscriber;

$tickerMap = [
    'btc'  => 90,
    'eth'  => 80,
    'doge' => 2,
    'ltc'  => 100,
    'xrp'  => 58,
    'bch'  => 134,
    'eos'  => 176,
    'bnb'  => 2710,
    'ada'  => 2010,
    'dot'  => 6636,
];

#minutely
Schedule::call(function () use ($tickerMap) {
    $subscribers = Subscriber::where('frequency', 'every_minute')->get();
    
    foreach ($subscribers as $subscriber) {
        $selectedIds = [];
        foreach ($tickerMap as $ticker => $coinId) {
            if ($subscriber->$ticker) {
                $selectedIds[] = $coinId;
            }
        }
        
        if (empty($selectedIds)) {
            continue;
        }
        
        $ids = implode(',', $selectedIds);
        
        $response = Http::get("https://api.coinlore.net/api/ticker/?id={$ids}");
        $coinData = $response->json();
        
        $allTickersResponse = Http::get('https://api.coinlore.net/api/tickers/');
        $allTickersData = $allTickersResponse->json()['data'];
        
        $data = [
            'subscriber' => $subscriber,
            'coins'      => $coinData,
            'alltickers' => $allTickersData,
        ];
        
        foreach ($tickerMap as $ticker => $coinId) {
            $data[$ticker] = $subscriber->$ticker;
        }
        
        Mail::to($subscriber->email)->send(new Newsletter($data));
    }
})->everyMinute();

//hourly
Schedule::call(function () use ($tickerMap) {
    $subscribers = Subscriber::where('frequency', 'hourly')->get();
    
    foreach ($subscribers as $subscriber) {
        $selectedIds = [];
        foreach ($tickerMap as $ticker => $coinId) {
            if ($subscriber->$ticker) {
                $selectedIds[] = $coinId;
            }
        }
        
        if (empty($selectedIds)) {
            continue;
        }
        
        $ids = implode(',', $selectedIds);
        $response = Http::get("https://api.coinlore.net/api/ticker/?id={$ids}");
        $coinData = $response->json();
        
        $allTickersResponse = Http::get('https://api.coinlore.net/api/tickers/');
        $allTickersData = $allTickersResponse->json()['data'];
        
        $data = [
            'subscriber' => $subscriber,
            'coins'      => $coinData,
            'alltickers' => $allTickersData,
        ];
        
        foreach ($tickerMap as $ticker => $coinId) {
            $data[$ticker] = $subscriber->$ticker;
        }
        
        Mail::to($subscriber->email)->send(new Newsletter($data));
    }
})->hourly();

//midnight
Schedule::call(function () use ($tickerMap) {
    $subscribers = Subscriber::where('frequency', 'daily')->get();
    
    foreach ($subscribers as $subscriber) {
        $selectedIds = [];
        foreach ($tickerMap as $ticker => $coinId) {
            if ($subscriber->$ticker) {
                $selectedIds[] = $coinId;
            }
        }
        
        if (empty($selectedIds)) {
            continue;
        }
        
        $ids = implode(',', $selectedIds);
        $response = Http::get("https://api.coinlore.net/api/ticker/?id={$ids}");
        $coinData = $response->json();
        
        $allTickersResponse = Http::get('https://api.coinlore.net/api/tickers/');
        $allTickersData = $allTickersResponse->json()['data'];
        
        $data = [
            'subscriber' => $subscriber,
            'coins'      => $coinData,
            'alltickers' => $allTickersData,
        ];
        
        foreach ($tickerMap as $ticker => $coinId) {
            $data[$ticker] = $subscriber->$ticker;
        }
        
        Mail::to($subscriber->email)->send(new Newsletter($data));
    }
})->dailyAt('00:00');


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

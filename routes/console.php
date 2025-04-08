<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Console\ClosureCommand;
use Illuminate\Support\Facades\Schedule;
use App\Mail\Newsletter;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use App\Models\Subscriber;

// Define a common mapping from ticker keys to Coinlore IDs.
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

// -----------------------------------------------------------------------------
// For subscribers who want the newsletter every minute:
Schedule::call(function () use ($tickerMap) {
    $subscribers = Subscriber::where('frequency', 'every_minute')->get();
    
    foreach ($subscribers as $subscriber) {
        // Build a list of Coinlore IDs for the currencies the subscriber selected.
        $selectedIds = [];
        foreach ($tickerMap as $ticker => $coinId) {
            if ($subscriber->$ticker) {
                $selectedIds[] = $coinId;
            }
        }
        
        // If no currencies were selected, skip this subscriber.
        if (empty($selectedIds)) {
            continue;
        }
        
        $ids = implode(',', $selectedIds);
        
        // Fetch the coin data for the selected currencies.
        $response = Http::get("https://api.coinlore.net/api/ticker/?id={$ids}");
        $coinData = $response->json();
        
        // Optionally fetch a full list of all tickers (if needed in the email)
        $allTickersResponse = Http::get('https://api.coinlore.net/api/tickers/');
        $allTickersData = $allTickersResponse->json()['data'];
        
        // Build the data array to pass to the Newsletter mailable.
        $data = [
            'subscriber' => $subscriber,
            'coins'      => $coinData,
            'alltickers' => $allTickersData,
        ];
        
        // Pass individual ticker booleans if the view needs them.
        foreach ($tickerMap as $ticker => $coinId) {
            $data[$ticker] = $subscriber->$ticker;
        }
        
        Mail::to($subscriber->email)->send(new Newsletter($data));
    }
})->everyMinute();

// -----------------------------------------------------------------------------
// For subscribers who want the newsletter hourly:
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

// -----------------------------------------------------------------------------
// For subscribers who want the newsletter daily at midnight:
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


// An example Artisan command (unchanged)
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

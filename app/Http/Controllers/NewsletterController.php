<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriber; 

class NewsletterController extends Controller
{
    public function showSignupForm()
    {
        return view('signup');
    }

    public function processSignup(Request $request)
    {
        $validatedData = $request->validate([
            'name'              => 'required|string',
            'email'             => 'required|email',
            'frequency'         => 'required|in:daily,hourly,every_minute',
            'percentage_alert'  => 'required|numeric|min:1.01',
            'captcha'           => 'required|captcha'
        ]);

        $tickers = ['btc', 'eth', 'doge', 'ltc', 'xrp', 'bch', 'eos', 'bnb', 'ada', 'dot'];
        $tickerData = [];

        foreach ($tickers as $ticker) {
            $tickerData[$ticker] = $request->has($ticker);
        }

        $data = array_merge($validatedData, $tickerData);

        Subscriber::create($data);

        return view('success');
    }
    
    public function unsubscribe(Request $request)
{
    $email = urldecode($request->query('email'));

    if (!$email) {
        return "Error: no email specified.";
    }
    $email = strtolower($email);
    $subscriber = Subscriber::where('email', $email)->first();
    if (!$subscriber) {
        return "Subscriber not found.";
    }
    $subscriber->delete();
    return view('unsubscribed');
}

}


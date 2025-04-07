<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'frequency',
        'percentage_alert',
        'btc', 'eth', 'doge', 'ltc', 'xrp', 'bch', 'eos', 'bnb', 'ada', 'dot'
    ];
}

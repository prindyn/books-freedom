<?php

namespace App\Http\Controllers\Api;

use BotMan\BotMan\BotMan;
use App\Contracts\BotFather;
use App\Http\Controllers\Controller;

class ApiBotController extends Controller
{
    public function register(BotMan $botman, BotFather $botfather)
    {
        dump($botfather->new());
    }
}

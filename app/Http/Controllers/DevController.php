<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use BotMan\Drivers\Telegram\TelegramDriver;
use Illuminate\Http\Request;

class DevController extends Controller
{
    public function index(Request $request, BotMan $bot)
    {
        dd($bot);
    }
}

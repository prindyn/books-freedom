<?php

namespace App\Services\Botman;

use App\Contracts\BotFather;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Output\BufferedOutput;

class TelegramBotFather implements BotFather
{
    public function new()
    {
        Artisan::call("botfather:msg", ['message' => '/newbot']);
        
        return Artisan::output();
    }
}

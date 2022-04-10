<?php

namespace App\Services\Botman;

use App\Contracts\BotFather;
use App\Services\Laragram\Laravel\TG;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Output\BufferedOutput;

class TelegramBotFather implements BotFather
{
    public function new()
    {
        return TG::sendMsg('BotFather', 'Hello there!');

        // Artisan::call("botfather:msg", ['message' => '/newbot']);

        // return Artisan::output();
    }
}

<?php

namespace App\Http\Controllers\Bot;

use BotMan\BotMan\BotMan;
use App\Http\Controllers\Controller;
use App\Services\Botman\Telegram\Extensions\WebAppInfo;
use BotMan\Drivers\Telegram\Extensions\Keyboard;
use App\Services\Botman\Telegram\Extensions\KeyboardButton;

class MainController extends Controller
{
    public function start(BotMan $bot)
    {
        $keyboard = Keyboard::create()
            ->type(Keyboard::TYPE_INLINE)
            ->addRow(
                KeyboardButton::create("Library")
                    ->webAppInfo(WebAppInfo::url(env('TG_WEBHOOK_URL') . '/library'))
            )
            ->toArray();
        $bot->reply('Hi, shall we find a book, or meet first?', $keyboard);
    }
}

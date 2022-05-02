<?php

namespace App\Http\Controllers\Bot;

use BotMan\BotMan\BotMan;
use App\Http\Controllers\Controller;
use BotMan\Drivers\Telegram\Extensions\Keyboard;
use BotMan\Drivers\Telegram\Extensions\KeyboardButton;

class MenuController extends Controller
{
    public function read(BotMan $bot)
    {
        $keyboard = Keyboard::create()
            ->type(Keyboard::TYPE_KEYBOARD)
            ->oneTimeKeyboard(true)
            ->addRow(
                KeyboardButton::create("Yes")->callbackData('first_inline'),
                KeyboardButton::create("No")->callbackData('second_inline')
            )
            ->toArray();
        $bot->reply('Text', $keyboard);
    }
}

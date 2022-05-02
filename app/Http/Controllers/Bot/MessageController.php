<?php

namespace App\Http\Controllers\Bot;

use BotMan\BotMan\BotMan;
use App\Http\Controllers\Controller;
use App\Conversations\ExampleConversation;
use BotMan\BotMan\Messages\Incoming\Answer;

class MessageController extends Controller
{
    public function welcome(BotMan $bot)
    {
        $bot->reply('Welcome to online books library!');
    }

    public function hello(BotMan $bot)
    {
        $this->askName($bot);
    }

    public function askName(BotMan $bot)
    {
        $bot->ask('Hello! What is your Name?', function (Answer $answer) {

            $this->say('Nice to meet you ' . $answer->getText());
        });
    }

    public function startConversation(BotMan $bot)
    {
        $bot->startConversation(new ExampleConversation());
    }
}

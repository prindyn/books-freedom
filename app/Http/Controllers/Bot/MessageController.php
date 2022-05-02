<?php

namespace App\Http\Controllers\Bot;

use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use BotMan\BotMan\Messages\Incoming\Answer;

class MessageController extends Controller
{
    public function index(BotMan $botman)
    {
        $this->askName($botman);
    }

    public function askName(BotMan $botman)
    {
        $botman->ask('Hello! What is your Name?', function (Answer $answer) {

            $this->say('Nice to meet you ' . $answer->getText());
        });
    }
}

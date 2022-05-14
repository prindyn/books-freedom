<?php

use BotMan\BotMan\BotMan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Bot\MainController;
use App\Http\Middleware\RegisterTelegramUser;
use App\Conversations\RegistrationConversation;
use App\Http\Middleware\IsBotMessageFromGroup;
use App\Http\Middleware\IsMessageDirectToBot;

/*
|--------------------------------------------------------------------------
| Botman Routes
|--------------------------------------------------------------------------
|
| Here is where you can register botman routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "bot" middleware group. Now create something great!
|
*/

Route::post('/', function (BotMan $bot) {

    $bot->group(['middleware' => new IsMessageDirectToBot], function ($bot) {
        $bot->middleware->received(new RegisterTelegramUser());

        $bot->hears('/start', MainController::class . '@start');

        $bot->hears('/register', function ($bot) {
            $bot->startConversation(new RegistrationConversation());
        });

        // $bot->fallback(function (BotMan $bot) {
        //     $bot->reply('Sorry, I did not understand these commands.');
        // });
    });

    $bot->group(['middleware' => new IsBotMessageFromGroup], function ($bot) {

        $bot->hears('/register', function ($bot) {
            $bot->startConversation(new RegistrationConversation());
        });

        $bot->hears('/find book {book}', function ($bot, $book) {
            $bot->reply($book);
        });
    });

    $bot->listen();
});

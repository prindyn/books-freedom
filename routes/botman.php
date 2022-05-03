<?php

use BotMan\BotMan\BotMan;
use Illuminate\Support\Facades\Route;
use App\Conversations\StartConversation;
use App\Http\Controllers\Bot\MainController;

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

    $bot->hears('/start|start', MainController::class . '@start');

    $bot->fallback(function (BotMan $bot) {
        $bot->reply('Sorry, I did not understand these commands.');
    });

    $bot->listen();
});

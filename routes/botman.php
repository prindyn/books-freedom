<?php

use BotMan\BotMan\BotMan;
use Illuminate\Support\Facades\Route;

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

    $bot->hears('start', 'App\Http\Controllers\Bot\MessageController@index');

    $bot->fallback(function (BotMan $bot) {
        $bot->reply('Sorry, I did not understand these commands.');
    });

    $bot->listen();
});

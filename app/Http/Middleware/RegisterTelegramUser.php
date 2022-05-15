<?php

namespace App\Http\Middleware;

use App\Models\TgUser;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Interfaces\Middleware\Received;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;
use Illuminate\Support\Facades\Log;

class RegisterTelegramUser implements Received
{
    /**
     * Handle an incoming message.
     *
     * @param IncomingMessage $message
     * @param callable $next
     * @param BotMan $bot
     *
     * @return mixed
     */
    public function received(IncomingMessage $message, $next, BotMan $bot)
    {
        $from = $bot->getDriver()->getUser($message);
        $user = TgUser::where('tg_id', $from->getId())->first();

        if (!$user) {
            try {
                $user = new TgUser([
                    'tg_id' => $from->getId(),
                    'is_bot' => $from->getInfo()['user']['is_bot'],
                    'first_name' => $from->getFirstName(),
                    'username' => $from->getUsername(),
                    'lang_code' => $from->getInfo()['user']['language_code'],
                ]);
                $user->save();
            } catch (\Exception $e) {
                Log::error('Telegram register user fail', (array) $e->getMessage());
            }
        }

        app('botman')->user = $user;

        return $next($message);
    }
}

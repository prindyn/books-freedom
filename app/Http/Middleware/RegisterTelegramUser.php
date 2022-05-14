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
        $user = TgUser::where('tg_id', $message->getSender())->first();

        if (!$user) {
            $payload = $message->getPayload();
            try {
                $user = new TgUser([
                    'tg_id' => $message->getSender(),
                    'is_bot' => $payload['from']['is_bot'],
                    'first_name' => $payload['from']['first_name'],
                    'username' => $payload['from']['username'],
                    'lang_code' => $payload['from']['language_code'],
                ]);
                $user->save();
            } catch (\Exception $e) {
                Log::error('Telegram register user fail', (array) $e->getMessage());
            }
        }

        app('botman')->dbUser = $user;

        return $next($message);
    }
}

<?php

namespace App\Services\Botman\Brokers;

use App\Services\Laragram\TG;

class TelegramBroker extends TG implements BotBrokerInterface
{
    public function __construct()
    {
        parent::__construct(config('services.telegram.socket'));
    }
}

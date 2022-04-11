<?php

namespace App\Services\Botman\Brokers;

interface BotBrokerInterface
{
    public function sendMsg($peer, $msg);

    public function getHistory($peer, $limit = null, $offset = null);
}
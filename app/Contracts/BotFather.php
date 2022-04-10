<?php

namespace App\Contracts;

use BotMan\BotMan\Facades\BotMan;

interface BotFather
{
    public function new(array $data);
}
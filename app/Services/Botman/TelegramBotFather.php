<?php

namespace App\Services\Botman;

use App\Contracts\BotFather;
use App\Services\Laragram\ITGAnswer;
use App\Services\Laragram\TGAnswer;

class TelegramBotFather extends BaseBotFather implements BotFather
{
    use TGAnswer;

    protected function peer()
    {
        return 'BotFather';
    }

    public function new(array $data)
    {
        $this->sendMsg($this->peer, '/newbot');

        $this->sendMsg($this->peer, $data['title']);

        $this->sendMsg($this->peer, $data['username']);

        return $this->response(ITGAnswer::BOT_REG_SUCCESS);
    }
}

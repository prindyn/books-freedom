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

        if (!$this->resultSuccess()) {
            return [
                'message' => ITGAnswer::BOT_REG_FAIL,
                'errors' => ['BotFather did not answer on /newbot']
            ];
        }

        if (!$this->commandAccepted()) {
            return [
                'message' => ITGAnswer::BOT_REG_FAIL,
                'errors' => $this->getAnswer('text')
            ];
        }

        $this->sendMsg($this->peer, $data['title']);

        if (!$this->resultSuccess()) {
            return [
                'message' => ITGAnswer::BOT_REG_FAIL,
                'errors' => ['BotFather did not answer after name setting']
            ];
        }

        if (!$this->commandAccepted()) {
            return [
                'message' => ITGAnswer::BOT_REG_FAIL,
                'errors' => $this->getAnswer('text')
            ];
        }

        $this->sendMsg($this->peer, $data['username']);

        if (!$this->commandAccepted()) {
            return [
                'message' => ITGAnswer::BOT_REG_FAIL,
                'errors' => $this->getAnswer('text')
            ];
        }

        return [
            'message' => ITGAnswer::BOT_REG_SUCCESS,
        ];
    }
}

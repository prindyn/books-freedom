<?php

namespace App\Services\Laragram;

interface ITGAnswer
{
    const SUCCESS = 'SUCCESS';
    const BOT_REG_FAIL = 'Fail to register new bot';
    const BOT_REG_SUCCESS = 'Telegram bot successfully created';

    const FAIL_ANSWERS = [
        'Unrecognized command. Say what?',
        'Sorry, this username is already taken. Please try something different.',
        'Sorry, the username must end in \'bot\'. E.g. \'Tetris_bot\' or \'Tetrisbot\'',
    ];
}

trait TGAnswer
{
    public function resultSuccess()
    {
        return $this->getAnswer('result') == ITGAnswer::SUCCESS;
    }

    public function commandAccepted($peer = '')
    {
        $peer = $peer ? $peer : $this->peer();

        $this->getHistory($peer, 1);

        return $this->getAnswer('text') &&
            !in_array($this->getAnswer('text'), ITGAnswer::FAIL_ANSWERS);
    }

    abstract protected function peer();

    abstract public function getAnswer();
}

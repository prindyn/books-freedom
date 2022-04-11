<?php

namespace App\Services\Laragram;

interface ITGAnswer
{
    const SUCCESS = 'SUCCESS';
    const BOT_RES_FAIL = 'BotFather action result fail';
    const BOT_REG_SUCCESS = 'Telegram bot successfully created';
    const BOT_NO_ANSWER = 'BotFather does not answer';
    const BOT_ENDS_TALK = 'BotFather stopped talking';
    const BOT_UNKNOWN_RES = 'BotFather unknown response';
    const TG_CLI_RES_FAIL = 'Server empty response';
    const BROKER_ACTION_FAIL = 'Broker action response fail';

    const FAIL_ANSWERS = [
        'Unrecognized command. Say what?',
        'Sorry, too many attempts. Please try again in',
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

    public function commandAccepted()
    {
        return empty(array_filter(ITGAnswer::FAIL_ANSWERS, function ($v, $k) {
            return stristr($this->getAnswer('text'), $v);
        }, ARRAY_FILTER_USE_BOTH));
    }

    abstract public function getAnswer($key = '');
}

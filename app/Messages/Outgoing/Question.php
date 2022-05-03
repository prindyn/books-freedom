<?php

namespace App\Messages\Outgoing;

use BotMan\BotMan\Messages\Outgoing\Question as OutgoingQuestion;

class Question extends OutgoingQuestion
{
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }
}
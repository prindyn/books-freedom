<?php

namespace App\Conversations;

use App\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;

class AcquaintanceConversation extends BaseConversation
{
    /**
     * Start the conversation
     */
    public function run()
    {
        $this->bot->ask('What is your name?', function ($answer, $conversation) {
            $conversation->say('Nice to meet you, ' . $answer->getText());
        });
    }
}

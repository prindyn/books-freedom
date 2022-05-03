<?php

namespace App\Conversations;

use App\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;

class StartConversation extends BaseConversation
{
    /**
     * Start the conversation
     */
    public function run()
    {
        $question = Question::create('Hi, shall we find a book, or meet first?')
            ->fallback('Please, make a choice...')
            ->addButtons([
                Button::create('Find a book')->value('findBook'),
                Button::create('Get acquainted')->value('acquaintance'),
            ]);

        return $this->ask($question, function ($answer) use ($question) {

            if ($answer->isInteractiveMessageReply()) {
                $conversation = $this->conversationClass($answer->getValue());

                return $this->bot->startConversation(new $conversation);
            } else {
                $question->setText('Please, make a choice...');
                $this->repeat($question);
            }
        });
    }
}

<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class StartConversation extends Conversation
{
    /**
     * Start the conversation
     */
    public function run()
    {
        $question = Question::create('Hi,<br>Would you like to relax with an interesting book, or shall we meet first?')
            ->addButtons([
                Button::create('Find a book')->value('find_book'),
                Button::create('Get acquainted')->value('get_acquainted'),
            ]);

        return $this->ask($question, function ($answer) {
            $this->say('Your choise is: ' . $answer->getValue());
        }, []);
    }
}

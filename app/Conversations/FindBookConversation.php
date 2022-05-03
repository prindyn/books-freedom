<?php

namespace App\Conversations;

use App\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;

class FindBookConversation extends BaseConversation
{
    /**
     * Start the conversation
     */
    public function run()
    {
        $question = Question::create('Please, enter book name:');

        return $this->ask($question, function ($answer) use ($question) {

            if (!$answer->isInteractiveMessageReply()) {
                $question->setText('Sorry, nothing found for `' . $answer->getText() . '`');
                $question->addButtons([
                    Button::create('Back')->value('/start'),
                    Button::create('Show our library')->value('library'),
                ]);

                $this->repeat($question);
            } else {
                $this->say($answer->getValue());
            }
        });
    }
}

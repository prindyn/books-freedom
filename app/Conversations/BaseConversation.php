<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;

class BaseConversation extends Conversation
{
    protected $bot;

    protected $message;

    public function __construct()
    {
        $this->message = '';
        $this->bot = app('botman');
    }

    protected function conversationClass($name)
    {
        return '\\App\Conversations\\' . ucfirst($name . 'Conversation');
    }

    /**
     * Start the conversation
     */
    public function run()
    {
    }
}

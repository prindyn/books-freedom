<?php

namespace App\Conversations;

use App\Messages\Outgoing\Question;
use Illuminate\Support\Facades\Validator;
use BotMan\BotMan\Messages\Conversations\Conversation;

abstract class BaseConversation extends Conversation
{
    protected $bot;

    protected $user;

    protected $message;

    protected $question;

    public function __construct()
    {
        $this->bot = app('botman');
        $this->user = $this->bot->user;
        $this->question = new Question(null);
    }

    protected function validate($param, $value = '')
    {
        $rules = method_exists($this, 'rules') ? call_user_func([$this, 'rules']) : [];
        $messages = method_exists($this, 'validateMessages') ? call_user_func([$this, 'validateMessages']) : [];
        $params = is_array($param) ? $param : [$param => $value];

        $rules = array_filter($rules, function ($v, $k) use ($params) {
            return isset($params[$k]);
        }, ARRAY_FILTER_USE_BOTH);

        return Validator::make($params, $rules, $messages);
    }

    protected function conversationClass($name)
    {
        return '\\App\Conversations\\' . ucfirst($name . 'Conversation');
    }

    abstract public function run();
}

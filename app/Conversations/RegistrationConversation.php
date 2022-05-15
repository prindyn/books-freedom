<?php

namespace App\Conversations;

class RegistrationConversation extends StagedConversation
{
    protected $stages = ['first_name', 'last_name', 'phone'];

    public function __construct()
    {
        parent::__construct();
        $user = $this->user->first_name ? ", {$this->user->first_name}" : "";
        $this->completeMessage = "Nice to meet you$user! 🙂";
    }

    protected function rules()
    {
        return [
            'first_name' => 'required|max:150',
            'last_name' => 'required|max:150',
            'phone' => 'required|numeric|min:9',
        ];
    }

    public function askFirstName()
    {
        $this->question->setText('What is your first name?');

        $this->ask($this->question, function ($answer) {

            $firstName = !$answer->isInteractiveMessageReply() ? $answer->getText() : '';
            $validator = $this->validate('first_name', $firstName);

            if ($validator->fails()) {
                $this->repeat($validator->errors()->first());
            } else {
                $this->nextCallbackStage('update', 'first_name', $answer->getText());
            }
        });
    }

    public function askLastName()
    {
        $this->question->setText('What is your last name?');

        $this->ask($this->question, function ($answer) {

            $lastName = !$answer->isInteractiveMessageReply() ? $answer->getText() : '';
            $validator = $this->validate('last_name', $lastName);

            if ($validator->fails()) {
                $this->repeat($validator->errors()->first());
            } else {
                $this->nextCallbackStage('update', 'last_name', $answer->getText());
            }
        });
    }

    public function askPhone()
    {
        $this->question->setText('Could I ask your phone number?' . PHP_EOL . self::SKIP_STAGE_MESSAGE);

        $this->ask($this->question, function ($answer) {

            if ($this->checkPreventAnswer($answer)) return;

            $validator = $this->validate('phone', $answer->getText());

            if ($validator->fails()) {
                $this->repeat($validator->errors()->first());
            } else {
                $this->nextCallbackStage('update', 'phone', $answer->getText());
            }
        });
    }

    protected function checkStage($param)
    {
        return empty(trim($this->user->$param));
    }

    protected function update($param, $value)
    {
        $this->user->$param = $value;
        $this->user->save();
    }
}

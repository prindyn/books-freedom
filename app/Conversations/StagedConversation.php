<?php

namespace App\Conversations;

abstract class StagedConversation extends BaseConversation
{
    const COMPLETE_MESSAGE = 'Complete. Thank you 🙂';
    const SKIP_STAGE_MESSAGE = 'Send /skip to skip this step.';

    protected $stages = [];

    protected $completeMessage = '';

    public function run()
    {
        foreach ($this->stages as $stage) {

            if ($this->checkStage($stage)) {
                return $this->nextStage();
            }
            array_shift($this->stages);
        }
        $this->nextStage();
    }

    protected function nextStage()
    {
        $stage = array_shift($this->stages);
        $stageMethod = 'ask' . implode('', array_map('ucfirst', explode('_', $stage)));

        if (!$stage || $stageMethod == 'ask') {
            return $this->say($this->completeMessage ?? self::COMPLETE_MESSAGE);
        }
        method_exists($this, $stageMethod) ? $this->$stageMethod() : $this->nextStage();
    }

    protected function nextCallbackStage($callable, ...$args)
    {
        if (is_callable($callable)) {

            call_user_func($callable, $args);
        } elseif (method_exists($this, $callable)) {

            call_user_func_array([$this, $callable], $args);
        }
        $this->nextStage();
    }

    protected function checkPreventAnswer($answer)
    {
        if ($answer->getText() == '/skip') return $this->nextStage();
    }

    abstract protected function checkStage($param);
}

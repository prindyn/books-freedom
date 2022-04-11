<?php

namespace App\Services\Botman;

use App\Services\Laragram\ITGAnswer;
use Prophecy\Exception\Doubler\ClassNotFoundException;
use Prophecy\Exception\Doubler\MethodNotFoundException;

abstract class BaseBotFather
{
    public $answer;

    protected $peer;

    protected $broker;

    protected $waitForAnswer = 1;

    public function __construct()
    {
        $this->peer = $this->peer();

        $this->broker = $this->broker(get_class($this), true);
    }

    public function getAnswer($key = '')
    {
        $answer = is_array($this->answer) ? current($this->answer) : $this->answer;

        if (!is_object($answer)) return ITGAnswer::TG_CLI_RES_FAIL;

        return $key ? ($answer->{$key} ?? null) : $answer;
    }

    public function broker(string $broker, bool $setBroker = false): mixed
    {
        $brokers = $this->brokers();

        if ($setBroker) {
            try {
                $brokerClass = "\\App\\Services\\Botman\\Brokers\\" . $brokers[$broker];

                if (!class_exists($brokerClass)) {
                    throw new ClassNotFoundException("Broker class not found.", $brokerClass);
                }
                return new $brokerClass;
            } catch (ClassNotFoundException $e) {
                echo $e->getMessage();
            }
        }

        return $broker ? ($brokers[$broker] ?? null) : $brokers;
    }

    public function validateResponse($peer = '')
    {
        $peer = $peer ? $peer : $this->peer();

        if (!$this->resultSuccess()) {
            return $this->errorResponse(ITGAnswer::BOT_RES_FAIL, ITGAnswer::BOT_NO_ANSWER);
        }
        try {
            if (!$this->broker || !method_exists($this->broker, 'getHistory')) {

                throw new MethodNotFoundException(
                    "Broker does not support this method (getHistory)",
                    get_class($this),
                    'getHistory'
                );
            }
            $this->answer = $this->broker->getHistory($peer, 1);

            if (!$this->commandAccepted()) {
                return $this->errorResponse(ITGAnswer::BOT_RES_FAIL, $this->getAnswer('text'));
            }
        } catch (MethodNotFoundException $e) {
            return $this->errorResponse(ITGAnswer::BOT_RES_FAIL, $e->getMessage() . '');
        }
    }

    public function response(string $message, bool $asJson = true): mixed
    {
        $response = ['message' => $message];

        return $asJson ? die(json_encode($response)) : $response;
    }

    public function errorResponse(string $message, mixed $errors, bool $asJson = true): mixed
    {
        $errors = is_array($errors) ? $errors : [$errors];

        $response = ['message' => $message, 'errors' => $errors];

        return $asJson ? die(json_encode($response)) : $response;
    }

    public function __call(string $name, array $arguments): mixed
    {
        try {
            if (!$this->broker || !method_exists($this->broker, $name)) {

                throw new MethodNotFoundException(
                    "Broker does not support this method ($name)",
                    get_class($this),
                    $name
                );
            }
            $this->answer = $this->broker->$name(...$arguments);

            sleep($this->waitForAnswer);

            return $this->validateResponse();
        } catch (MethodNotFoundException $e) {
            return $this->errorResponse(ITGAnswer::BOT_RES_FAIL, $e->getMessage());
        }
    }

    protected function brokers(): array
    {
        return [
            'App\Services\Botman\TelegramBotFather' => 'TelegramBroker',
        ];
    }

    abstract protected function peer();

    abstract public function resultSuccess();

    abstract public function commandAccepted();
}

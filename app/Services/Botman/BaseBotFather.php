<?php

namespace App\Services\Botman;

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

        if (!is_object($answer)) return null;

        return $key ? ($answer->{$key} ?? null) : $answer;
    }

    protected function broker(string $broker, bool $setBroker = false): mixed
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

    protected function brokers(): array
    {
        return [
            'App\Services\Botman\TelegramBotFather' => 'TelegramBroker',
        ];
    }

    public function __call(string $name, array $arguments): void
    {
        try {
            if (!$this->broker) {
                throw new MethodNotFoundException("Broker does not support this method.", get_class($this), $name);
            }
            $this->answer = $this->broker->$name(...$arguments);

            sleep($this->waitForAnswer);
        } catch (MethodNotFoundException $e) {
            echo $e->getMessage();
        }
    }

    abstract protected function peer();
}

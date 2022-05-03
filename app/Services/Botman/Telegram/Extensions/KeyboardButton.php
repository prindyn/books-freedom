<?php

namespace App\Services\Botman\Telegram\Extensions;

use Illuminate\Support\Collection;
use BotMan\Drivers\Telegram\Extensions\KeyboardButton as BaseKeyboardButton;

/**
 * Class KeyboardButton.
 */
class KeyboardButton extends BaseKeyboardButton
{
    /**
     * @var WebAppInfo
     */
    protected $webAppInfo;

    /**
     * @param $text
     * @return KeyboardButton
     */
    public static function create($text)
    {
        return new static($text);
    }

    /**
     * @param $app
     * @return $this
     */
    public function webAppInfo($app)
    {
        $this->webAppInfo = $app;

        return $this;
    }

    /**
     * Specify data which should be serialized to JSON.
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return Collection::make([
            'url' => $this->url,
            'text' => $this->text,
            'callback_data' => $this->callbackData,
            'request_contact' => $this->requestContact,
            'request_location' => $this->requestLocation,
            'web_app' => $this->webAppInfo,
        ])->filter()->toArray();
    }
}

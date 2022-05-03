<?php

namespace App\Services\Botman\Telegram\Extensions;

use Illuminate\Support\Collection;

/**
 * Class WebAppInfo.
 */
class WebAppInfo implements \JsonSerializable
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @param $url
     * @return WebAppInfo
     */
    public static function url($url)
    {
        return new self($url);
    }

    /**
     * WebAppInfo constructor.
     * @param $url
     */
    public function __construct($url)
    {
        $this->url = $url;
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
        ])->filter()->toArray();
    }
}

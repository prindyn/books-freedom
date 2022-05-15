<?php

namespace App\Services\Botman\Telegram\Messages\Attachments;

use BotMan\BotMan\Messages\Attachments\Attachment;

class Invoice extends Attachment
{
    /**
     * Pattern that messages use to identify invoice attachment.
     */
    const PATTERN = '%%%_INVOICE_%%%';

    /** @var string */
    protected $title;

    /** @var string */
    protected $description;

    /** @var string */
    protected $photo_url;

    /**
     * Message constructor.
     *
     * @param string $title
     * @param string $description
     * @param string $photo_url
     */
    public function __construct($title, $description, $photo_url, $payload = null)
    {
        parent::__construct($payload);
        $this->title = $title;
        $this->description = $description;
        $this->photo_url = $photo_url;
    }

    /**
     * @param string $title
     * @param string $description
     * @param string $photo_url
     *
     * @return Invoice
     */
    public static function create($title, $description, $photo_url)
    {
        return new self($title, $description, $photo_url);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getPhotoUrl()
    {
        return $this->photo_url;
    }

    /**
     * Get the instance as a web accessible array.
     * This will be used within the WebDriver.
     *
     * @return array
     */
    public function toWebDriver()
    {
        return [
            'type' => 'invoice',
            'title' => $this->title,
            'description' => $this->description,
            'photo_url' => $this->photo_url,
        ];
    }
}

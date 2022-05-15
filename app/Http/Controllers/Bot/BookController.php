<?php

namespace App\Http\Controllers\Bot;

use App\Http\Controllers\Controller;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use Illuminate\Support\Facades\Log;
use Scriptotek\GoogleBooks\GoogleBooks;

class BookController extends Controller
{
    public function find($bot, $query)
    {
        $books = new GoogleBooks();

        $bot->types();

        try {
            foreach ($books->volumes->search($query) as $volume) {
                Log::info(print_r($volume, true));
                $attachment = new Image($volume->imageLinks->thumbnail, ['custom_payload' => true]);

                $message = OutgoingMessage::create($volume->title)
                    ->withAttachment($attachment);

                return $bot->reply($message);
            }
        } catch (\Exception $e) {
            //
        }

        return $bot->reply('Nothing found.');
    }
}

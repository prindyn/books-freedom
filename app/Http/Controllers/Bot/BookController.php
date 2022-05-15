<?php

namespace App\Http\Controllers\Bot;

use App\Http\Controllers\Controller;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use Scriptotek\GoogleBooks\GoogleBooks;
use BotMan\Drivers\Telegram\Extensions\Keyboard;
use BotMan\Drivers\Telegram\Extensions\KeyboardButton;

class BookController extends Controller
{
    public function find($bot, $query)
    {
        $books = new GoogleBooks();

        $bot->types();

        try {
            foreach ($books->volumes->search($query) as $book) {

                $image = str_ireplace('zoom=1', 'zoom=3', $book->imageLinks->thumbnail);
                $caption = view('telegram.book-caption', compact('book'))->render();

                $attachment = (new Image($image))
                    ->title($caption);
                $message = OutgoingMessage::create()
                    ->withAttachment($attachment);

                $keyboard = Keyboard::create()
                    ->type(Keyboard::TYPE_INLINE)
                    ->addRow(
                        KeyboardButton::create("Read")->url('https://t.me/books_freedom_bot'),
                    )
                    ->toArray();

                return $bot->reply($message, [
                    'parse_mode' => 'html',
                    'protect_content' => true,
                ] + $keyboard);
            }
        } catch (\Exception $e) {
            //
        }

        return $bot->reply('Nothing found.');
    }
}

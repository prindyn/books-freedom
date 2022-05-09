<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    const REQUEST_EXPIRE = 5;

    public function download(Request $request, $book)
    {
        try {
            foreach (range(1, self::REQUEST_EXPIRE) as $number) {
                if (Storage::exists(
                    'books/lock/' . md5($book . now()->subSeconds($number))
                )) {
                    return Storage::download("books/$book");
                }
            }
            throw new Exception();
        } catch (\Exception $e) {
            return response()->json(['message' => __('Book not found')], 404);
        }
    }

    public function request(Request $request, $book)
    {
        if (!Storage::exists("books/$book")) {
            return response()->json(['message' => __('Book not found')], 404);
        }

        try {
            $hash = md5($book . now());

            Storage::put("books/lock/$hash", "");

            return response()->json(['book' => $book], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => __('Impossible to create hash')], 404);
        }
    }
}

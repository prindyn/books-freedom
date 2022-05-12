<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Book;
use App\Filters\BookFilters;
use Illuminate\Http\Request;
use App\Http\Requests\BookRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    const REQUEST_EXPIRE = 5;

    public function store(BookRequest $request)
    {
        $validated = $request->validated();
        $filename = md5(uniqid() . now());

        if ($request->cover) {
            $validated['cover'] = $filename . '.' . $request->cover->getClientOriginalExtension();
            Storage::disk('images')->putFileAs("covers", $request->cover, $validated['cover']);
        }

        if ($request->source) {
            $validated['source'] = $filename . '.' . $request->source->getClientOriginalExtension();
            Storage::putFileAs("books", $request->source, $validated['source']);
        }

        $book = new Book($validated);
        $book->save();

        return response()->json(
            [
                'success' => true,
                'message' => 'Book created successfully'
            ]
        );
    }

    public function books(BookFilters $filters)
    {
        $books = Book::filter($filters)->get();

        foreach ($books as $book) {
            $book->cover = url("images/covers/{$book->cover}");
            $book->last_page = 0;
        }

        return response()->json(['books' => $books]);
    }

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
            $lock = "books/lock/$hash";

            Storage::put($lock, "");

            app()->terminating(function () use ($lock) {
                sleep(self::REQUEST_EXPIRE);
                Storage::delete($lock);
            });

            return response()->json(['book' => $book], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => __('Impossible to create hash')], 404);
        }
    }
}

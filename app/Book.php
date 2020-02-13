<?php

namespace App;

use App\Events\BookAdded;
use App\Events\BookRemoved;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $guarded = [];

    public static function assignBook($bookData, $libraryData)
    {
        $book = self::find($bookData['id'] ?? null);

        if (is_null($book)) {
            unset($bookData['in_library']);
            $book = new self($bookData);
            $book->save();
        }

        $library = Library::find($libraryData['id'] ?? null);
        $library->books()->attach($book->id);
        $bookData['in_library'] = true;
        $bookData['id'] = $book->id;

        event(new BookAdded($library, $book));

        return $bookData;
    }

    public static function unassignBook($bookData, $libraryData)
    {
        $library = Library::find($libraryData['id'] ?? null);
        $library->books()->detach($bookData['id']);
        $bookData['in_library'] = false;

        $book = self::find($bookData['id'] ?? null);
        event(new BookRemoved($library, $book));

        return $bookData;
    }
}

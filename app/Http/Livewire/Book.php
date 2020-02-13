<?php

namespace App\Http\Livewire;

use App\Events\BookAdded;
use App\Events\BookRemoved;
use App\Library;
use App\Book as BookM;
use Carbon\Carbon;
use Livewire\Component;

class Book extends Component
{
    public $book, $library;

    public $exists;

    public function getListeners()
    {
        $id = $this->book['id'];

        if (! $id) {
            return [];
        }

        return [
            "echo:books=$id,BookAdded" => 'notifyAddBook',
            "echo:books=$id,BookRemoved" => 'notifyRemoveBook',
        ];
    }

    public function notifyAddBook($parameters)
    {
        $this->book['in_library'] = true;
    }

    public function notifyRemoveBook($parameters)
    {

        $this->book['in_library'] = false;
    }

    public function mount($book, $library)
    {
        $this->book = $book;
        $this->library = $library;
    }

    public function render()
    {
        return view('livewire.book');
    }

    public function assignBook()
    {
        $book = BookM::find($this->book['id'] ?? null);

        if (is_null($book)) {
            unset($this->book['in_library']);
            $book = new BookM($this->book);
            $book->save();
        }

        $library = Library::find($this->library['id'] ?? null);
        $library->books()->attach($book->id);
        $this->book['in_library'] = true;
        $this->book['id'] = $book->id;

        event(new BookAdded($library, $book));
    }

    public function unassignBook()
    {
        $library = Library::find($this->library['id'] ?? null);
        $library->books()->detach($this->book['id']);
        $this->book['in_library'] = false;

        $book = BookM::find($this->book['id'] ?? null);
        event(new BookRemoved($library, $book));
    }
}

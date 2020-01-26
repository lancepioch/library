<?php

namespace App\Http\Livewire;

use App\Library;
use App\Book as BookM;
use Livewire\Component;

class Book extends Component
{
    protected $book, $library;

    public $exists;

    public function mount($book, $library)
    {
        $this->book = $book;
        $this->library = $library;
    }

    public function render()
    {
        $book = $this->book;
        $library = $this->library;

        return view('livewire.book', compact(['book', 'library']));
    }

    public function assignBook()
    {
        $book = BookM::find($this->book['id'] ?? null);
        if ($book === null) {
            unset($this->book['in_library']);
            $book = $this->book;
            $book->save();
        }

        $library = Library::find($this->library['id'] ?? null);
        $library->books()->attach($book->id);
        $this->book['in_library'] = true;
        $this->book['id'] = $book->id;
    }

    public function unassignBook()
    {
        $library = Library::find($this->library['id'] ?? null);
        $library->books()->detach($this->book['id']);
        $this->book['in_library'] = false;
    }
}

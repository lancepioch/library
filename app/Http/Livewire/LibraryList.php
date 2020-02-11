<?php

namespace App\Http\Livewire;

use App\Library;
use Livewire\Component;

class LibraryList extends Component
{
    public $library;
    public $books;

    protected $listeners = ['echo:books,BookAdded' => 'notifyNewBook'];

    public function mount(Library $library)
    {
        $this->library = $library;
        $this->books = $library->books;
    }

    public function notifyNewBook($parameters)
    {
        $book = $parameters['book'];

        $this->books[] = \App\Book::find($book['id']);
    }

    public function render()
    {
        $this->books->transform(function ($book) {
            $book->in_library = true;

            return $book;
        });

        return view('livewire.library');
    }
}

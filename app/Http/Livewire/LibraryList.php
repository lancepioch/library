<?php

namespace App\Http\Livewire;

use App\Library;
use Livewire\Component;

class LibraryList extends Component
{
    public $library;
    public $books;

    protected $listeners = [
        'echo:books,BookAdded' => 'notifyNewBook',
        'echo:books,BookRemoved' => 'notifyRemovedBook',
    ];

    public function mount(Library $library)
    {
        $this->library = $library;
        $this->books = $library->books;
    }

    public function notifyNewBook($parameters)
    {
        $this->books[] = \App\Book::find($parameters['book']['id']);
    }

    public function notifyRemovedBook($parameters)
    {
        foreach ($this->books as $key => $book) {
            if ($book->id == $parameters['book']['id']) {
                $this->books->forget($key);
            }
        }
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

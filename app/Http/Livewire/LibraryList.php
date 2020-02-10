<?php

namespace App\Http\Livewire;

use App\Library;
use Livewire\Component;

class LibraryList extends Component
{
    public $library;

    protected $listeners = ['echo:books,BookAdded' => 'notifyNewBook'];

    public function mount(Library $library)
    {
        $this->library = $library;
    }

    public function notifyNewBook($parameters)
    {
        
    }

    public function render()
    {
        $library = $this->library;

        $library->books->transform(function ($book) {
            $book->in_library = true;

            return $book;
        });

        return view('livewire.library');
    }
}

<?php

namespace App\Http\Livewire;

use App\Events\BookAdded;
use App\Events\BookRemoved;
use App\Library;
use App\Book as BookM;
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
        $this->book = BookM::assignBook($this->book, $this->library);
    }

    public function unassignBook()
    {
        $this->book = BookM::unassignBook($this->book, $this->library);
    }
}

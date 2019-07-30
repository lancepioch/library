<?php

namespace App\Http\Livewire;

use App\Book;
use App\Library;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Livewire\Component;

class BookList extends Component
{
    public $library;

    public $results = [];

    public $search = '';

    public $test = 0;

    public $isbn = '';

    public function mount(Library $library)
    {
        $this->library = $library;
    }

    public function render()
    {
        return view('livewire.book-list');
    }

    public function search()
    {
        $client = new Client();
        $url = 'https://www.googleapis.com/books/v1/volumes?q=' . urlencode($this->search);
        $res = $client->request('GET', $url);

        $json = $res->getBody();
        $results = json_decode($json, true);

        $books = collect();

        foreach ($results['items'] as $book) {
            $exists = false;
            $isbn = $book['volumeInfo']['industryIdentifiers'][0]['identifier'] ?? '';
            $b = Book::where('isbn', $isbn)->first();
            $library = Library::findOrFail($this->library['id']);
            if ($b) {
                $exists = $library->books->contains($b->id);
            }

            $books->add(new Book([
                'id' => $b->id ?? null,
                'title' => $book['volumeInfo']['title'],
                'subtitle' => $book['volumeInfo']['subtitle'] ?? '',
                'isbn' => $isbn,
                'description' => $book['volumeInfo']['description'] ?? '',
                'google_id' => $book['id'] ?? '',
                'published_at' => new Carbon($book['volumeInfo']['publishedDate']),
                'in_library' => $exists,
            ]));
        }

        $this->results = $books->take(6);
    }

    public function testTest($i = 9)
    {
        $this->test = $i;
    }
}

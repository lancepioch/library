<?php

namespace App\Http\Livewire;

use App\Book;
use App\Library;
use GuzzleHttp\Client;
use Livewire\Component;

class BookList extends Component
{
    public $library;

    protected $results = [];

    public $search = '';

    public $test = 0;

    public $isbn = '';

    public function mount(Library $library)
    {
        $this->library = $library;
    }

    public function render()
    {
        $results = $this->results;
        $library = $this->library;

        return view('livewire.book-list', compact('results', 'library'));
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

            $previousBook = Book::where('isbn', $isbn)->first();
            if ($previousBook) {
                $exists = $this->library->books->contains($previousBook->id);
            }

            $books->add([
                'id' => $previousBook->id ?? null,
                'title' => $book['volumeInfo']['title'],
                'subtitle' => $book['volumeInfo']['subtitle'] ?? '',
                'isbn' => $isbn,
                'description' => $book['volumeInfo']['description'] ?? '',
                'google_id' => $book['id'] ?? '',
                'published_at' => $book['volumeInfo']['publishedDate'],
                'in_library' => $exists,
            ]);
        }

        $this->results = $books;
    }

    public function testTest($i = 9)
    {
        $this->test = $i;
    }
}

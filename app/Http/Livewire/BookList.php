<?php

namespace App\Http\Livewire;

use App\Book;
use App\Library;
use GuzzleHttp\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;

class BookList extends Component
{
    use WithPagination;

    public $library;

    protected $results = [];

    public $search = '';

    public $page = 1;

    public $test = 0;

    public $isbn = '';

    const PER_PAGE = 10;

    protected $updatesQueryString = ['search', 'page'];

    public function mount(Library $library)
    {
        $this->library = $library;
        $this->search = request()->query('search', $this->search);
        $this->paginator['page'] = request()->query('page', $this->page);
    }

    public function render()
    {
        if (! empty($this->search)) {
            $this->search();
        }

        $results = $this->results;
        $library = $this->library;

        return view('livewire.book-list', compact('results', 'library'));
    }

    public function search()
    {
        $client = new Client();
        $currentPage = $this->paginator['page'] ?? 1;
        $this->page = $currentPage;
        $startIndex = ($currentPage - 1) * self::PER_PAGE;
        $url = "https://www.googleapis.com/books/v1/volumes?startIndex=$startIndex&q=" . urlencode($this->search);
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

        $totalCount = $results['totalItems'];
        $books = (new LengthAwarePaginator($books, $totalCount, self::PER_PAGE, $currentPage));

        $this->results = $books;
    }

    public function testTest($i = 9)
    {
        $this->test = $i;
    }
}

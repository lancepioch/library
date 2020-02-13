<div>
    <div class="container mx-auto flex w-full flex-wrap">

        <div class="justify-content-center flex w-full">
            <h2>{{ $library->name }}</h2>
            <h3>{{ $library->description }}</h3>
        </div>


        <div class="justify-content-center flex w-full">
            <a
                href="{{ route('booklist', [$library]) }}"
                class="ml-4 flex-shrink-0 bg-blue-500 hover:bg-blue-600 focus:outline-none focus:shadow-outline text-white font-bold py-2 px-4 rounded"
            >Add Books</a>
        </div>

        @forelse ($books as $book)
            @livewire('book', $book, $library, key($book->google_id))
        @empty
            Add some books to your library!
        @endforelse

    </div>
</div>

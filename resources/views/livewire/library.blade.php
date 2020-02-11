<div>
    <div class="container mx-auto flex w-full flex-wrap">

        @forelse ($books as $book)
            @livewire('book', $book, $library, key($book->google_id))
        @empty
            Add some books to your library!
        @endforelse

    </div>
</div>

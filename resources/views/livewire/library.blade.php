<div>
    <div class="container mx-auto flex w-full flex-wrap">

        <div class="justify-content-center flex w-full">
            <h2>{{ $library->name }}</h2>
            <h3>{{ $library->description }}</h3>
        </div>

        @forelse ($books as $book)
            @livewire('book', $book, $library, key($book->google_id))
        @empty
            Add some books to your library!
        @endforelse

    </div>
</div>

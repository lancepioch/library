
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">

    @livewire('book-list', \App\Library::with('books')->findOrFail(1))

    @livewireAssets


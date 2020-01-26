
<div class="w-full sm:w-1/2 md:w-1/3 xl:w-1/5 rounded overflow-hidden shadow-md">
    <div>
        <div class="justify-center flex">
            <img class="h-40 py-2"
                 src="https://books.google.com/books/content?id={{ $book['google_id'] ?? '' }}&printsec=frontcover&img=1&zoom=5"
                 alt="{{ $book['title'] }}">
        </div>

        @if ($book['in_library'])
            <button wire:click="unassignBook" class="m-4 ml-4 flex-shrink-0 bg-red-500 hover:bg-red-600 focus:outline-none focus:shadow-outline text-white font-bold py-2 px-2 rounded">Remove from Library</button>
        @else
            <button wire:click="assignBook" class="m-4 ml-4 flex-shrink-0 bg-blue-500 hover:bg-blue-600 focus:outline-none focus:shadow-outline text-white font-bold py-2 px-2 rounded">Add to Library</button>
        @endif

        <div class="px-6 py-4">
            <div class="font-bold text-xl mb-2" title="{{ $book['title'] }}">{{ Str::limit($book['title'], 50) }}</div>
            <p class="text-gray-700 text-base">{{ Str::limit($book['description'] ?? '', 50) }}</p>
        </div>
    </div>
</div>

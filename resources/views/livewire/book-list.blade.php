<div>
    <form class="flex w-full max-w-sm mx-auto m-4" wire:submit.prevent="search">
        <input type="search" wire:model.lazy="search" class="flex-1 bg-gray-200 hover:bg-white hover:border-gray-300 focus:outline-none focus:bg-white focus:shadow-outline focus:border-gray-300 appearance-none border border-transparent rounded w-full py-2 px-4 text-gray-700 leading-tight" placeholder="Book Title or ISBN">

        <button class="ml-4 flex-shrink-0 bg-blue-500 hover:bg-blue-600 focus:outline-none focus:shadow-outline text-white font-bold py-2 px-4 rounded">Search</button>

        <div wire:loading>Loading Search...</div>
    </form>

    <div class="container mx-auto flex w-full flex-wrap">
        {{ $isbn }}
    @forelse($results as $result)
        @livewire('book', $result, $library, key($result['google_id']))
    @empty
    @endforelse

        @if ($results instanceof \Illuminate\Pagination\AbstractPaginator)
        <div class="flex w-full justify-content-center py-3">
            {{ $results->links() }}
        </div>
        @endif
    </div>
</div>

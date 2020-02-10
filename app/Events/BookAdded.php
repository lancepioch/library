<?php

namespace App\Events;

use App\Book;
use App\Library;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BookAdded implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $book, $library;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Library $library, Book $book)
    {
        $this->library = $library;
        $this->book = $book;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return [
            new Channel('books'),
            new Channel("books={$this->book->id}"),
        ];
    }
}

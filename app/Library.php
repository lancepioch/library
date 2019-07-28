<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function books()
    {
        $this->morphedByMany(Book::class, 'mediable');
    }
}

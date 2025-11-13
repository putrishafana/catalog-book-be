<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'book';

    public function authors()
    {
        return $this->belongsTo(Author::class, 'author_id', 'id');
    }

    public function publishers()
    {
        return $this->belongsTo(Publisher::class, 'publisher_id', 'id');
    }
}
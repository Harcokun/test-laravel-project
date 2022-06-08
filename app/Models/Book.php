<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Store;
use App\Models\BookType;

class Book extends Model
{
    use HasFactory;
    /**
     * Get the post that owns the comment.
     */
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    public function bookType()
    {
        return $this->belongsTo(BookType::class);
    }
}

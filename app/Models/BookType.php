<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Book;

class BookType extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}

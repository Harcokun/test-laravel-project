<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Book;
use App\Models\Telephone;
use App\Models\User;

class Store extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];
    
    public function telephones()
    {
        return $this->hasMany(Telephone::class);
    }
    public function books()
    {
        return $this->hasMany(Book::class);
    }
    public function owners()
    {
        return $this->belongsToMany(User::class);
    }
}

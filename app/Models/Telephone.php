<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Store;

class Telephone extends Model
{
    use HasFactory;

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}

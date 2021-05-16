<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'user_name',
        'book_id',
    ];
}

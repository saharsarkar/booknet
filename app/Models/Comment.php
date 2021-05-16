<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'book_id',
        'user_id',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeReviewerComments($query)
    {
        return $this->whereHas('user', function ($query) {
            $query->where('reviewer', 1);
        })->orderBy(static::CREATED_AT, 'desc')->get();
    }

    public function scopeUserComments($query)
    {
        return $this->whereHas('user', function ($query) {
            $query->where('reviewer', 0);
        })->get();
    }
}

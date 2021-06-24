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

    /**
     * Filter all reviewer's comments
     */
    public function scopeReviewerComments($query)
    {
        return $query->whereHas('user', function ($query) {
            $query->where('reviewer', 1);
        })->orderBy(static::CREATED_AT, 'desc')->get();
    }

    /**
     * Filter not reviewer's comments
     */
    public function scopeUserComments($query)
    {
        return $query->whereHas('user', function ($query) {
            $query->where('reviewer', 0);
        })->get();
    }
}

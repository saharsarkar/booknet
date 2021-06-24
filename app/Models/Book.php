<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'year',
        'user_id',
        'publisher_id',
        'pdf',
        'image',
        'digikala',
    ];

    // Relations

    // One-to-one User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // One-to-one publisher
    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }
    // One-to-many authors
    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }
    // One-to-many categories
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
    // One-to-many comments
    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }
    // One-to-many guestComments
    public function guestComments()
    {
        return $this->hasMany(GuestComment::class)->latest();
    }

    // Scopes

    /**
     * Sort books based on latest
     */
    public function scopeLatest($query)
    {
        return $query->orderBy(static::CREATED_AT, 'desc');
    }

    /**
     * Search books model with given title
     */
    public function scopeSearch($query, $title)
    {
        return $query
            ->where('title', 'like', "%{$title}%")
            ->with(['publisher', 'authors'])
            ->orderBy('books.created_at', 'desc');
    }

    /**
     * Retrieve pdf file url
     */
    public function pdf_url()
    {
        return Storage::url($this->pdf);
    }

    /**
     * Retrieve pdf file url
     */
    public function image_url()
    {
        return Storage::url($this->image);
    }
}

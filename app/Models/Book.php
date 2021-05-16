<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Book extends Model implements Searchable
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'year',
        'user_id',
        'publisher_id',
        'pdf_path'
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }


    // Scopes
    public function scopeLatest($query)
    {
        return $query->orderBy(static::CREATED_AT, 'desc');
    }

    public function url()
    {
        return Storage::url($this->pdf_path);
    }

    // Search interface
    public function getSearchResult(): SearchResult
    {
        $url = route('book.show', ['book' => $this->id]);

        return new SearchResult(
            $this,
            $this->title,
            $url
        );
    }
}

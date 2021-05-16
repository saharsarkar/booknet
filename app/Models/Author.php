<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Author extends Model implements Searchable
{
    use HasFactory;

    protected $fillable = ['name'];

    // Relations
    public function books()
    {
        return $this->belongsToMany(Book::class);
    }

    // Scopes
    public function scopeRetrieveAuthorsId($query, $authors)
    {
        foreach ($authors as $author) {
            $this->firstOrCreate(['name' => $author]);
        }
        return $query->whereIn('name', $authors)->get()->pluck('id');
    }

    // Search interface
    public function getSearchResult(): SearchResult
    {
        $url = route('author.show', ['author' => $this->id]);

        return new SearchResult(
            $this,
            $this->name,
            $url
        );
    }
}

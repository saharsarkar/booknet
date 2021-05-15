<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Publisher extends Model implements Searchable
{
    use HasFactory;

    protected $fillable = ['name'];

    // Search interface
    public function getSearchResult(): SearchResult
    {
        $url = route('publisher.show', ['publisher' => $this->id]);

        return new SearchResult(
            $this,
            $this->name,
            $url
        );
    }
}

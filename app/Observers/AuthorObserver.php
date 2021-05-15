<?php

namespace App\Observers;

use App\Models\Author;
use Illuminate\Support\Facades\Cache;

class AuthorObserver
{
    public function creating()
    {
        Cache::tags(['authors'])->forget('author-list');
    }

    public function updating(Author $author)
    {
        Cache::tags(['authors'])->forget('author-list');
        Cache::tags(['authors'])->forget("author-{$author->id}");
    }

    public function deleting(Author $author)
    {
        Cache::tags(['authors'])->forget('author-list');
        Cache::tags(['authors'])->forget("author-{$author->id}");
    }
}

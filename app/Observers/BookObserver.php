<?php

namespace App\Observers;

use App\Models\Book;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class BookObserver
{
    public function created(Book $book)
    {
        Cache::tags(['books'])->forget('book-list');

        $this->clearCaches($book);
    }

    public function updating(Book $book)
    {
        // Clear caches
        Cache::tags(['books'])->forget('book-list');
        Cache::tags(['books'])->forget("book-{$book->id}");
        Cache::tags(['comments'])->forget("book-{$book->id}-comment-list");

        $this->clearCaches($book);
    }

    public function deleting(Book $book)
    {
        Cache::tags(['books'])->forget('book-list');
        Cache::tags(['books'])->forget("book-{$book->id}");
        Cache::tags(['comments'])->forget("book-{$book->id}-comment-list");

        $this->clearCaches($book);

        // Delete the book's pdf file from storage
        Storage::delete($book->pdf_path);

        // Delete the book's images
        foreach ($book->images as $image) {
            Storage::delete($image->path);
        }
        $book->images()->delete();
    }

    private function clearCaches(Book $book)
    {
        Cache::tags(['authors'])->forget('author-list');
        Cache::tags(['publishers'])->forget('publisher-list');
        Cache::tags(['categories'])->forget('category-list');

        Cache::tags(['publishers'])->forget("publisher-{$book->publisher_id}");

        // Clear all the book's author's cache
        foreach ($book->authors as $author) {
            Cache::tags(['authors'])->forget("author-{$author->id}");
        }
        // Clear all the book's category's cache
        foreach ($book->categories as $category) {
            Cache::tags(['categories'])->forget("category-{$category->id}");
        }
    }
}

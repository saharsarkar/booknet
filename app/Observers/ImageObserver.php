<?php

namespace App\Observers;

use App\Models\Book;
use App\Models\Image;
use Illuminate\Support\Facades\Cache;

class ImageObserver
{
    public function created(Image $image)
    {
        $this->clearBookCache($image->book_id);
    }

    public function updating(Image $image)
    {
        $this->clearBookCache($image->book_id);

        Cache::tags(['images'])->forget("book-{$image->book_id}-image-{$image->id}");
    }

    public function deleting(Image $image)
    {
        $this->clearBookCache($image->book_id);

        Cache::tags(['images'])->forget("book-{$image->book_id}-image-{$image->id}");
    }

    private function clearBookCache($book_id)
    {
        Cache::tags(['books'])->forget('book-list');
        Cache::tags(['books'])->forget("book-{$book_id}");
        Cache::tags(['images'])->forget("book-{$book_id}-image-list");
    }
}

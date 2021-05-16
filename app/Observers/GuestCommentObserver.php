<?php

namespace App\Observers;

use App\Models\GuestComment;
use Illuminate\Support\Facades\Cache;

class GuestCommentObserver
{
    public function created(GuestComment $guestComment)
    {
        $this->clearBookCache($guestComment->book_id);
    }

    public function updating(GuestComment $guestComment)
    {
        $this->clearBookCache($guestComment->book_id);

        Cache::tags(['comments'])->forget("book-{$guestComment->book_id}-comment-{$guestComment->id}");
    }

    public function deleting(GuestComment $guestComment)
    {
        $this->clearBookCache($guestComment->book_id);

        Cache::tags(['comments'])->forget("book-{$guestComment->book_id}-comment-{$guestComment->id}");
    }

    private function clearBookCache($book_id)
    {
        Cache::tags(['books'])->forget('book-list');
        Cache::tags(['books'])->forget("book-{$book_id}");
        Cache::tags(['comments'])->forget("book-{$book_id}-comment-list");
    }
}

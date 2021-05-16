<?php

namespace App\Observers;

use App\Models\Comment;
use Illuminate\Support\Facades\Cache;

class CommentObserver
{
    public function created(Comment $comment)
    {
        $this->clearBookCache($comment->book_id);
    }

    public function updating(Comment $comment)
    {
        $this->clearBookCache($comment->book_id);

        Cache::tags(['comments'])->forget("book-{$comment->book_id}-comment-{$comment->id}");
    }

    public function deleting(Comment $comment)
    {
        $this->clearBookCache($comment->book_id);

        Cache::tags(['comments'])->forget("book-{$comment->book_id}-comment-{$comment->id}");
    }

    private function clearBookCache($book_id)
    {
        Cache::tags(['books'])->forget('book-list');
        Cache::tags(['books'])->forget("book-{$book_id}");
        Cache::tags(['comments'])->forget("book-{$book_id}-comment-list");
    }
}

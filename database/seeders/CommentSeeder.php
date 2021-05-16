<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Comment;
use App\Models\GuestComment;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $books = Book::all();

        if ($books->count() === 0) {
            $this->command->info('There is no books, so no comment added!');
            return;
        }

        $userCommentCount = (int)$this->command->ask('How many user comments would you like?', 75);
        $guestCommentCount = (int)$this->command->ask('How many guest comments would you like?', 75);

        Comment::factory($userCommentCount)->make()->each(function ($comment) use ($users, $books) {
            $comment->user_id = $users->random()->id;
            $comment->book_id = $books->random()->id;
            $comment->save();
        });

        GuestComment::factory($guestCommentCount)->make()->each(function ($comment) use ($books) {
            $comment->book_id = $books->random()->id;
            $comment->save();
        });
    }
}

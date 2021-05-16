<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Publisher;
use App\Models\User;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::where('role', 'admin')->get();
        $publishers = Publisher::all();

        $bookCount = (int)$this->command->ask('How many books would you like?', 20);

        Book::factory($bookCount)->make()->each(function ($book) use ($users, $publishers) {
            $book->user_id = $users->random()->id;
            $book->publisher_id = $publishers->random()->id;
            $book->save();
        });
    }
}

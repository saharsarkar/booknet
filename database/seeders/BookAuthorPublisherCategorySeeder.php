<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;

class BookAuthorPublisherCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $authorCount = Author::all()->count();
        $categoryCount = Category::all()->count();

        $authorRange = [
            'min' => (int)$this->command->ask('Minimum authors on books ?', 1),
            'max' => min((int)$this->command->ask('Maximum authors on books ?', $authorCount / 2), $authorCount / 2)
        ];

        $categoryRange = [
            'min' => (int)$this->command->ask('Minimum categories on books ?', 1),
            'max' => min((int)$this->command->ask('Maximum categories on books ?', $categoryCount / 2), $categoryCount / 2)
        ];

        Book::all()->each(function (Book $book) use ($authorRange, $categoryRange) {
            // Pick a random number between min and max
            $authorCount = random_int($authorRange['min'], $authorRange['max']);
            $categoryCount = random_int($categoryRange['min'], $categoryRange['max']);

            // Retrieve authors based on random number
            $authors = Author::inRandomOrder()->take($authorCount)->get()->pluck('id');
            // Retrieve authors based on random number
            $categories = Category::inRandomOrder()->take($categoryCount)->get()->pluck('id');

            // Assign them to book
            $book->authors()->sync($authors);
            $book->categories()->sync($categories);
        });
    }
}

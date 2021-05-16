<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Database\Seeder;

class AuthorPublisherCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $authorCount = max((int)$this->command->ask('How many authors would you like?', 10), 5);
        $categoryCount = max((int)$this->command->ask('How many category would you like?', 10), 5);
        $publisherCount = max((int)$this->command->ask('How many publisher would you like?', 10), 5);

        Author::factory($authorCount)->create();
        Category::factory($categoryCount)->create();
        Publisher::factory($publisherCount)->create();
    }
}

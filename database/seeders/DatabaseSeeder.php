<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Ask questions from user
        if ($this->command->confirm('Want to refresh database?', true)) {
            $this->command->call('migrate:refresh');
            $this->command->info('Database is seeded');
        }

        // Call seeders
        $this->call([
            UserSeeder::class,
            AuthorPublisherCategorySeeder::class,
        ]);
    }
}

<?php

namespace Database\Seeders;

use Database\Seeders\SeedUsers;
use Illuminate\Database\Seeder;
use Database\Seeders\SeedIntereses;
use Database\Seeders\SeedRelInteresesUser;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       $this->call([
            SeedIntereses::class,
            SeedUsers::class,
            SeedRelInteresesUser::class
       ]);
    }
}

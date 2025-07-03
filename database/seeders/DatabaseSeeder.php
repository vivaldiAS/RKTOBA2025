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
        // \App\Models\Gallery::factory(300)->create();
        // \App\Models\Warehouse::factory(300)->create();
        $this->call([
            UsersTableSeeder::class,
        ]);
        // \App\Models\Warehouse::factory(300)->create();
    }
}

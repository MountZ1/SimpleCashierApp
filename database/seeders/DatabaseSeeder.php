<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Ardi Saputra',
            'username' => 'ardisaputra',
            'email' => 'ardisaputra@gmail.com',
            'password' => bcrypt('password'),
        ]);
        User::factory()->count(5)->create();
    }
}

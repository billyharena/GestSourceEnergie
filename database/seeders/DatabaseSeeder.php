<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->admin()->create([
            'name' => 'Admin',
            'lastname' => 'AdminTest',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
        ]);

        User::factory()->create([
            'role' => 0,
            'name' => 'user01',
            'lastname' => 'user01Test',
            'email' => 'user01@gmail.com',
            'password' =>bcrypt('user01'),
        ]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}

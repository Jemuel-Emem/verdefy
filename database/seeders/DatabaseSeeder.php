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
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([

            'name' => 'ADMINISTRATOR',
            'email' => 'admin@gmail.com',
            'address' => 'admin@gmail.com',
            'phonenumber' => '09232323232',
            'avatar' => 'logo.png',
         'password' => bcrypt('password'),
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        User::create([

            'name' => 'Test',
            'email' => 'test@gmail.com',
            'address' => 'test@gmail.com',
            'phonenumber' => '09232323232',
            'avatar' => 'logo.png',
         'password' => bcrypt('password'),
            'is_admin' => false,
            'email_verified_at' => now(),
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();

        \App\Models\User::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'admin_one@mail.com',
            'password'=> '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'uuid' => Str::uuid(),
            'is_admin' => true,
        ]);

        \App\Models\User::create([
            'first_name' => 'Mark',
            'last_name' => 'White',
            'email' => 'admin_two@mail.com',
            'password'=> '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'uuid' => Str::uuid(),
            'is_admin' => true,
        ]);
    }
}

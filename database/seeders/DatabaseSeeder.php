<?php

namespace Database\Seeders;

use App\Models\Internship;
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
        User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'username' => 'adminKyu',
            'password' => bcrypt('admin#1234'),
            'role' => 'admin',
        ]);
        User::factory()->create([
            'name' => 'Maidy chan',
            'username' => 'maidy112',
            'password' => bcrypt('1234567890'),
            'role' => 'admin',
        ]);
        User::factory()->create([
            'name' => 'Staff-chan',
            'username' => 'stafchn',
            'password' => bcrypt('1234567890'),
            'role' => 'admin',
        ]);

        // Internship::factory(10)->recycle([User::all()])->create();
    }
}

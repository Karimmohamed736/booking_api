<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'karim',
            'email' => 'karim@gmail.com',
            'role' => 'admin',
            'password' => bcrypt('12341234')
        ]);
        User::create([
            'name' => 'mohamed',
            'email' => 'mohamed@gmail.com',
            'role' => 'user',
            'password' => bcrypt('12341234')
        ]);
    }
}

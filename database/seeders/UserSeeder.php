<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Teacher A',
            'email' => 'teacher@example.com',
            'password' => Hash::make('password'),
            'role' => 'teacher'
        ]);

        User::create([
            'name' => 'Student A',
            'email' => 'student@example.com',
            'password' => Hash::make('password'),
            'role' => 'student'
        ]);
    }
}


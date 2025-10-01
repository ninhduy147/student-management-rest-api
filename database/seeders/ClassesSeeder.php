<?php

namespace Database\Seeders;

use App\Models\Classes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Classes::create([
            'class_code' => 'CSE101',
            'class_name' => 'Computer Science 101'
        ]);

        Classes::create([
            'class_code' => 'MAT202',
            'class_name' => 'Mathematics 202'
        ]);
    }
}

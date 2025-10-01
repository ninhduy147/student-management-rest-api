<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Student::create([
            'user_id' => 3, // user student A
            'student_code' => 'SV001',
            'full_name' => 'Nguyen Van A',
            'birthday' => '2003-05-10',
            'gender' => 0,
            'class_id' => 1
        ]);
    }
}

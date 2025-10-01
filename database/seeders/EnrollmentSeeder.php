<?php

namespace Database\Seeders;

use App\Models\Enrollment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Enrollment::create([
            'student_id' => 1,
            'subject_id' => 1
        ]);

        Enrollment::create([
            'student_id' => 1,
            'subject_id' => 2
        ]);
    }
}

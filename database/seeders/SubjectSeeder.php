<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Subject::create([
            'subject_code' => 'SUB001',
            'subject_name' => 'Web Programming',
            'teacher_id' => 2
        ]);

        Subject::create([
            'subject_code' => 'SUB002',
            'subject_name' => 'Database Systems',
            'teacher_id' => 2
        ]);
    }
}

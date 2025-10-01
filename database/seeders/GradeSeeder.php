<?php

namespace Database\Seeders;

use App\Models\Grade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Grade::create([
            'enrollment_id' => 1,
            'midterm' => 7.5,
            'final' => 8.0
        ]);

        Grade::create([
            'enrollment_id' => 2,
            'midterm' => 6.0,
            'final' => 7.0
        ]);
    }
}

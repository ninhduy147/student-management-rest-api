<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GradeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'midterm' => $this->midterm,
            'final' => $this->final,
            'average' => $this->average,
            'student_name' => $this->enrollment->student->full_name ?? null,
            'subject_name' => $this->enrollment->subject->subject_name ?? null,
        ];
    }
}

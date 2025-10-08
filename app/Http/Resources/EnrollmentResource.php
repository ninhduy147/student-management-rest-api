<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EnrollmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'student' => [
                'id' => $this->student->id ?? null,
                'student_code' => $this->student->student_code ?? null,
                'full_name' => $this->student->full_name ?? null,
            ],
            'subject' => [
                'id' => $this->subject->id ?? null,
                'subject_code' => $this->subject->subject_code ?? null,
                'subject_name' => $this->subject->subject_name ?? null,
            ],
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}

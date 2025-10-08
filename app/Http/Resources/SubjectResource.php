<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubjectResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'subject_code' => $this->subject_code,
            'subject_name' => $this->subject_name,
            'teacher_name' => $this->users->full_name ?? null, // lấy tên giáo viên
        ];
    }
}


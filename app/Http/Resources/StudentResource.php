<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'student_code' => $this->student_code,
            'full_name' => $this->full_name,
            'birthday' => $this->birthday,
            'gender' => $this->gender,
            'class_name' => $this->classes->class_name ?? null,
        ];
    }
}


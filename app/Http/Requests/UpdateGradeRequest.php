<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGradeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'enrollment_id' => 'sometimes|exists:enrollments,id',
            'midterm'       => 'sometimes|numeric|min:0|max:10',
            'final'         => 'sometimes|numeric|min:0|max:10',
            // 'average'       => 'nullable|numeric|min:0|max:10',
        ];
    }

    public function messages(): array
    {
        return [
            'enrollment_id.exists'   => 'Enrollment không tồn tại.',
            'midterm.numeric'        => 'Điểm giữa kỳ phải là số.',
            'midterm.min'            => 'Điểm giữa kỳ phải >= 0.',
            'midterm.max'            => 'Điểm giữa kỳ phải <= 10.',
            'final.numeric'          => 'Điểm cuối kỳ phải là số.',
            'final.min'              => 'Điểm cuối kỳ phải >= 0.',
            'final.max'              => 'Điểm cuối kỳ phải <= 10.',
            // 'average.numeric'        => 'Điểm trung bình phải là số.',
            // 'average.min'            => 'Điểm trung bình phải >= 0.',
            // 'average.max'            => 'Điểm trung bình phải <= 10.',
        ];
    }
}

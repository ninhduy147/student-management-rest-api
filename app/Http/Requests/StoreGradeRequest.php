<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGradeRequest extends FormRequest
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
            'enrollment_id' => 'required|exists:enrollments,id',
            'midterm'       => 'required|numeric|min:0|max:10',
            'final'         => 'required|numeric|min:0|max:10',
            // 'average'       => 'nullable|numeric|min:0|max:10',
        ];
    }

    public function messages(): array
    {
        return [
            'enrollment_id.required' => 'Thiếu mã ghi danh (enrollment_id).',
            'enrollment_id.exists'   => 'Enrollment không tồn tại.',
            'midterm.required'       => 'Điểm giữa kỳ là bắt buộc.',
            'midterm.numeric'        => 'Điểm giữa kỳ phải là số.',
            'midterm.min'            => 'Điểm giữa kỳ phải >= 0.',
            'midterm.max'            => 'Điểm giữa kỳ phải <= 10.',
            'final.required'         => 'Điểm cuối kỳ là bắt buộc.',
            'final.numeric'          => 'Điểm cuối kỳ phải là số.',
            'final.min'              => 'Điểm cuối kỳ phải >= 0.',
            'final.max'              => 'Điểm cuối kỳ phải <= 10.',
        ];
    }
}

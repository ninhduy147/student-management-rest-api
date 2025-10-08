<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEnrollmentRequest extends FormRequest
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
            'student_id' => [
                'required',
                'exists:students,id',
                // không cho trùng cặp student-subject khác id hiện tại
                Rule::unique('enrollments')
                    ->where(fn ($query) => $query->where('subject_id', $this->subject_id))
                    ->ignore($this->route('enrollment')),
            ],
            'subject_id' => ['required', 'exists:subjects,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'student_id.required' => 'Vui lòng chọn sinh viên.',
            'student_id.exists'   => 'Sinh viên không tồn tại.',
            'student_id.unique'   => 'Sinh viên này đã đăng ký môn học này rồi.',
            'subject_id.required' => 'Vui lòng chọn môn học.',
            'subject_id.exists'   => 'Môn học không tồn tại.',
        ];
    }
}

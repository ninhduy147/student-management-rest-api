<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Student;
use App\Models\Enrollment;

class StoreEnrollmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $user = $this->user();

        // Lấy student_id thật sự (nếu là student thì dựa vào user_id)
        $studentId = $user && $user->role === 'student'
            ? optional(Student::where('user_id', $user->id)->first())->id
            : $this->input('student_id');

        return [
            // Nếu là sinh viên thì bỏ qua, còn lại required
            'student_id' => $user && $user->role === 'student'
                ? 'nullable'
                : 'required|exists:students,id',

            'subject_id' => [
                'required',
                'exists:subjects,id',

                // Custom rule: không cho đăng ký trùng
                function ($attribute, $value, $fail) use ($studentId) {
                    if ($studentId && Enrollment::where('student_id', $studentId)
                        ->where('subject_id', $value)
                        ->exists()) {
                        $fail('Sinh viên này đã đăng ký môn học này rồi.');
                    }
                },
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'student_id.required' => 'Vui lòng chọn sinh viên',
            'student_id.exists'   => 'Sinh viên không tồn tại',
            'subject_id.required' => 'Vui lòng chọn môn học',
            'subject_id.exists'   => 'Môn học không tồn tại',
        ];
    }
}

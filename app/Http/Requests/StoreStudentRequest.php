<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
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
            // 'user_id' => 'required|exists:users,id',
            'student_code' => 'required|string|max:20|unique:students,student_code',
            'full_name' => 'required|string|max:255',
            'birthday' => 'nullable|date|before:today',
            'gender' => 'required|boolean',
            'class_id' => 'nullable|exists:classes,id',
        ];
    }
    public function messages()
    {
        return [
            // 'user_id.required' => 'Thiếu thông tin người dùng.',
            // 'user_id.exists' => 'Người dùng không tồn tại.',

            'student_code.required' => 'Mã sinh viên là bắt buộc.',
            'student_code.unique' => 'Mã sinh viên đã tồn tại.',
            'student_code.max' => 'Mã sinh viên không được vượt quá 20 ký tự.',

            'full_name.required' => 'Họ và tên là bắt buộc.',
            'full_name.max' => 'Họ và tên không được vượt quá 255 ký tự.',

            'birthday.date' => 'Ngày sinh phải là ngày hợp lệ.',
            'birthday.before' => 'Ngày sinh phải nhỏ hơn ngày hiện tại.',

            'gender.required' => 'Vui lòng chọn giới tính.',
            'gender.boolean' => 'Giới tính không hợp lệ.',

            'class_id.exists' => 'Lớp học không tồn tại.',
        ];
    }

}

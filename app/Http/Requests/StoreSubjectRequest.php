<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubjectRequest extends FormRequest
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
        $subjectId = $this->route('subject');

        return [
            'subject_code' => 'required|string|max:20|unique:subjects,subject_code,' . $subjectId,
            'subject_name' => 'required|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'subject_code.required' => 'Mã môn học là bắt buộc.',
            'subject_code.string'   => 'Mã môn học phải là chuỗi ký tự.',
            'subject_code.max'      => 'Mã môn học không được vượt quá 20 ký tự.',
            'subject_code.unique'   => 'Mã môn học này đã tồn tại.',

            'subject_name.required' => 'Tên môn học là bắt buộc.',
            'subject_name.string'   => 'Tên môn học phải là chuỗi ký tự.',
            'subject_name.max'      => 'Tên môn học không được vượt quá 100 ký tự.',

        ];
    }
}

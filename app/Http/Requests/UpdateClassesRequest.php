<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateClassesRequest extends FormRequest
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
        $classId = $this->route('class'); // lấy id từ route {class}

        return [
            'class_code' => [
                'sometimes',
                'string',
                'max:25',
                Rule::unique('classes', 'class_code')->ignore($classId)
            ],
            'class_name' => [
                'sometimes',
                'string',
                'max:255',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'class_code.required' => 'Mã lớp không được để trống.',
            'class_code.string'   => 'Mã lớp phải là chuỗi ký tự.',
            'class_code.max'      => 'Mã lớp tối đa 25 ký tự.',
            'class_code.unique'   => 'Mã lớp đã tồn tại, vui lòng chọn mã khác.',

            'class_name.required' => 'Tên lớp không được để trống.',
            'class_name.string'   => 'Tên lớp phải là chuỗi ký tự.',
            'class_name.max'      => 'Tên lớp tối đa 255 ký tự.',
        ];
    }

}

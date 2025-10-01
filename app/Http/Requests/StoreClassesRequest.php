<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClassesRequest extends FormRequest
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
            'class_code'=> 'required|string|unique:classes,class_code|max:25',
            'class_name' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
       return [
            'class_code.required' => 'Mã lớp không được để trống.',
            'class_code.string'   => 'Mã lớp phải là chuỗi ký tự.',
            'class_code.unique'   => 'Mã lớp đã tồn tại, vui lòng chọn mã khác.',
            'class_code.max'      => 'Mã lớp không được dài quá 25 ký tự.',

            'class_name.required' => 'Tên lớp không được để trống.',
            'class_name.string'   => 'Tên lớp phải là chuỗi ký tự.',
            'class_name.max'      => 'Tên lớp không được dài quá 255 ký tự.',
        ];
    }
}

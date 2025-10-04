<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:50',
            // 'role' => 'required|in:admin,user',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[A-Z]/',      // ít nhất 1 chữ hoa
                'regex:/[0-9]/',      // ít nhất 1 số
                'regex:/[@$!%*#?&]/', // ít nhất 1 ký tự đặc biệt
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên không được để trống.',
            'name.string'   => 'Tên phải là chuỗi ký tự.',
            'name.min'      => 'Tên phải có ít nhất :min ký tự.',
            'name.max'      => 'Tên không được vượt quá :max ký tự.',

            // 'role.required' => 'Vai trò là bắt buộc.',
            // 'role.in'       => 'Vai trò không hợp lệ. Chỉ chấp nhận: admin, user.',

            'email.required' => 'Email không được để trống.',
            'email.email'    => 'Email không đúng định dạng.',
            'email.max'      => 'Email không được vượt quá :max ký tự.',
            'email.unique'   => 'Email này đã tồn tại trong hệ thống.',

            'password.required' => 'Mật khẩu không được để trống.',
            'password.string'   => 'Mật khẩu phải là chuỗi ký tự.',
            'password.min'      => 'Mật khẩu phải có ít nhất :min ký tự.',
            'password.regex'    => 'Mật khẩu phải chứa ít nhất 1 chữ hoa, 1 số và 1 ký tự đặc biệt.',
        ];
    }
}

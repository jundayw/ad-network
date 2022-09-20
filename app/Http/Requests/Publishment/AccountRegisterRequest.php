<?php

namespace App\Http\Requests\Publishment;

use App\Http\Requests\FormRequest;
use App\Rules\Captcha;

class AccountRegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'type' => ['required'],
            'username' => ['required', 'alpha_dash', 'between:4,16', 'unique:publisher,username'],
            'password' => ['required', 'between:6,16'],
            'email' => ['required', 'email:rfc,dns', 'unique:publisher,mail'],
            'captcha' => [new Captcha('signup')],
            'code' => ['required'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'type' => '邮件',
            'username' => '用户名',
            'password' => '密码',
            'email' => '邮件',
            'code' => '邮箱验证码',
        ];
    }
}

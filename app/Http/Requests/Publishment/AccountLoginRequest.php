<?php

namespace App\Http\Requests\Publishment;

use App\Http\Requests\FormRequest;
use App\Rules\Captcha;

class AccountLoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'alpha_dash', 'between:4,16'],
            'password' => ['required', 'between:6,16'],
            'captcha' => [new Captcha('login')],
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
            'username' => '用户名',
            'password' => '密码',
        ];
    }
}

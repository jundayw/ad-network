<?php

namespace App\Http\Requests\Advertisement;

use App\Http\Requests\FormRequest;
use App\Rules\Captcha;

class AccountMailRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email:rfc,dns'],
            'captcha' => [new Captcha('signup')],
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
            'email' => '邮件',
        ];
    }
}

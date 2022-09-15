<?php

namespace App\Http\Requests\Backend;

use App\Http\Requests\FormRequest;

class ProfilePasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return $this->isMethod('POST') ? [
            'userpass' => ['required', 'between:6,16'],
            'password' => ['required', 'same:userpass'],
        ] : [];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'userpass' => '密码',
            'password' => '确认密码',
        ];
    }
}

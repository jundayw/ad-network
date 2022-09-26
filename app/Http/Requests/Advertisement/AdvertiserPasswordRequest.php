<?php

namespace App\Http\Requests\Advertisement;

use App\Http\Requests\FormRequest;

class AdvertiserPasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'id' => ['required'],
            'userpass' => ['required', 'between:6,16'],
            'password' => ['required', 'same:userpass'],
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
            'id' => '主键',
            'userpass' => '密码',
            'password' => '确认密码',
        ];
    }
}

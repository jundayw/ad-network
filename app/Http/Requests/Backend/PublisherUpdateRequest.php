<?php

namespace App\Http\Requests\Backend;

use App\Http\Requests\FormRequest;

class PublisherUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'role' => ['required'],
            'usernick' => ['required'],
            'username' => ['required', 'alpha_dash', 'between:4,16', "unique:publisher,username,{$this->get('id')}"],
            'password' => ['nullable', 'between:6,16'],
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
            'role' => '角色',
            'usernick' => '昵称',
            'username' => '用户名',
            'password' => '密码',
        ];
    }
}

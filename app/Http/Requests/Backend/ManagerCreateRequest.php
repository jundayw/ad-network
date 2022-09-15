<?php

namespace App\Http\Requests\Backend;

use App\Http\Requests\FormRequest;

class ManagerCreateRequest extends FormRequest
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
            'username' => ['required', 'alpha_dash', 'between:4,16', 'unique:manager,username'],
            'userpass' => ['required', 'between:6,16'],
            'password' => ['required', 'same:userpass'],
            'state' => ['required'],
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
            'userpass' => '密码',
            'password' => '确认密码',
            'state' => '状态',
        ];
    }
}

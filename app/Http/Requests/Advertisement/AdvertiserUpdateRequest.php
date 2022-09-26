<?php

namespace App\Http\Requests\Advertisement;

use App\Http\Requests\FormRequest;

class AdvertiserUpdateRequest extends FormRequest
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
            'usernick' => ['required'],
            'username' => ['required', 'alpha_dash', 'between:4,16', "unique:advertiser,username,{$this->get('id')}"],
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
            'id' => '主键',
            'usernick' => '昵称',
            'username' => '用户名',
            'state' => '状态',
        ];
    }
}

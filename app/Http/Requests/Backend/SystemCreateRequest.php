<?php

namespace App\Http\Requests\Backend;

use App\Http\Requests\FormRequest;

class SystemCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $rules = [
            'title' => ['required'],
            'key' => ['required', 'unique:system,key'],
            'type' => ['required'],
            'modifiable' => ['required'],
        ];

        if (in_array($this->get('type'), ['radio', 'select', 'checkbox'])) {
            $rules['options'] = ['required', 'json'];
        }

        return $rules;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'title' => '名称',
            'key' => '键名',
            'type' => '类型',
            'options' => '配置',
            'modifiable' => '是否允许编辑',
        ];
    }
}

<?php

namespace App\Http\Requests\Backend;

use App\Http\Requests\FormRequest;

class RoleCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'module_id' => ['required'],
            'title' => ['required'],
            'sorting' => ['required', 'gte:1'],
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
            'module_id' => '模块',
            'title' => '名称',
            'sorting' => '排序',
        ];
    }
}

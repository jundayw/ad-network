<?php

namespace App\Http\Requests\Backend;

use App\Http\Requests\FormRequest;

class ModuleUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
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
            'title' => '模块名称',
            'sorting' => '排序',
        ];
    }
}

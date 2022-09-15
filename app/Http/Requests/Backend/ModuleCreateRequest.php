<?php

namespace App\Http\Requests\Backend;

use App\Http\Requests\FormRequest;

class ModuleCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'namespace' => ['required'],
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
            'namespace' => '标识符',
            'title' => '模块名称',
            'sorting' => '排序',
        ];
    }
}

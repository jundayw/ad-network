<?php

namespace App\Http\Requests\Backend;

use App\Http\Requests\FormRequest;

class RoleUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => ['required'],
            'policies' => ['required', 'array'],
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
            'title' => '名称',
            'policies' => '策略',
            'sorting' => '排序',
        ];
    }
}

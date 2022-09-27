<?php

namespace App\Http\Requests\Backend;

use App\Http\Requests\FormRequest;

class CreativeUpdateRequest extends FormRequest
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
            'location' => ['required'],
            'image' => ['required'],
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
            'location' => '链接地址',
            'image' => '图片地址',
        ];
    }
}

<?php

namespace App\Http\Requests\Advertisement;

use App\Http\Requests\FormRequest;

class CreativeCreateRequest extends FormRequest
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
            'size' => ['required', 'gte:1'],
            'element' => ['required', 'gte:1'],
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
            'size' => '广告尺寸',
            'element' => '广告单元',
            'location' => '链接地址',
            'image' => '图片地址',
        ];
    }
}

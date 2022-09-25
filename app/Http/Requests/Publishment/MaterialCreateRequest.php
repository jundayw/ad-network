<?php

namespace App\Http\Requests\Publishment;

use App\Http\Requests\FormRequest;

class MaterialCreateRequest extends FormRequest
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
            'device' => ['required'],
            'size' => ['required', 'gte:1'],
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
            'device' => '设备',
            'size' => '广告尺寸',
            'location' => '链接地址',
            'image' => '图片地址',
        ];
    }
}

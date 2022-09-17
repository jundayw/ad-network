<?php

namespace App\Http\Requests\Backend;

use App\Http\Requests\FormRequest;

class SizeUpdateRequest extends FormRequest
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
        ];

        if ($this->get('pid')) {
            $rules['width']  = ['required', 'gte:1'];
            $rules['height'] = ['required', 'gte:1'];
            $rules['device'] = ['required', 'array'];
            $rules['type']   = ['required', 'array'];
        }

        $rules['sorting'] = ['required', 'gte:1'];

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
            'width' => '宽度',
            'height' => '高度',
            'device' => '设备',
            'type' => '展现类型',
            'sorting' => '排序',
        ];
    }
}

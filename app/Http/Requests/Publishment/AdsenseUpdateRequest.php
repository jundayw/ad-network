<?php

namespace App\Http\Requests\Publishment;

use App\Http\Requests\FormRequest;

class AdsenseUpdateRequest extends FormRequest
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
            'origin' => ['required'],
            'device' => ['required'],
            'type' => ['required'],
            'vacant' => ['required'],
        ];

        if ($this->get('vacant') == 'default') {
            $rules['image'] = ['required'];
        }

        if ($this->get('vacant') == 'union') {
            $rules['code'] = ['required'];
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
            'origin' => '类型',
            'device' => '设备',
            'type' => '展现类型',
            'vacant' => '空闲设置',
            'image' => '图片地址',
            'code' => '联盟广告代码',
        ];
    }
}

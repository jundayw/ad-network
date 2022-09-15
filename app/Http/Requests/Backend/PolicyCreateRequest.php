<?php

namespace App\Http\Requests\Backend;

use App\Http\Requests\FormRequest;

class PolicyCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $rules = [
            'module' => ['required'],
            'title' => ['required'],
            'icon' => ['required'],
            'sorting' => ['required'],
        ];

        $module = $this->get('module');
        $module = explode(',', $module);

        if (count($module) >= 2) {
            $rules['url']       = ['required'];
            $rules['statement'] = ['required'];
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
            'module' => '所属策略',
            'title' => '名称',
            'icon' => '图标',
            'url' => '地址',
            'statement' => '授权语句',
            'sorting' => '排序',
        ];
    }
}

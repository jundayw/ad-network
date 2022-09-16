<?php

namespace App\Http\Requests\Publishment;

use App\Http\Requests\FormRequest;

class SiteUpdateRequest extends FormRequest
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
            'protocol' => ['required'],
            'industry' => ['required'],
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
            'protocol' => '协议',
            'industry' => '站点领域',
        ];
    }
}

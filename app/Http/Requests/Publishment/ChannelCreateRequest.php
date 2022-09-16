<?php

namespace App\Http\Requests\Publishment;

use App\Http\Requests\FormRequest;

class ChannelCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'site' => ['required'],
            'title' => ['required'],
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
            'site' => '站点',
            'title' => '名称',
        ];
    }
}

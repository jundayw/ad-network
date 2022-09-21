<?php

namespace App\Http\Requests\Advertisement;

use App\Http\Requests\FormRequest;

class ProgramUpdateRequest extends FormRequest
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
            'limit' => ['required', 'gte:1'],
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
            'limit' => '日限额',
        ];
    }
}

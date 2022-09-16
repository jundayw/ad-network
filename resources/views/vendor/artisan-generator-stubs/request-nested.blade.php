<?php

namespace DummyNamespace;

use App\Http\Requests\FormRequest;

class DummyRequestClass extends FormRequest
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
            'sorting' => '排序',
        ];
    }
}

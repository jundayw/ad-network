<?php

namespace App\Http\Requests\Publishment;

use App\Http\Requests\FormRequest;
use App\Rules\Mobile;

class ProfileInfoRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return $this->isMethod('POST') ? [
            'name' => ['required', "unique:publishment,name,{$this->user()->getAttribute('publishment_id')}"],
            'licence' => ['required', "unique:publishment,licence,{$this->user()->getAttribute('publishment_id')}"],
            'licence_image' => ['required'],
            'corporation' => ['required'],
            'mobile' => ['required', new Mobile()],
        ] : [];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'name' => '认证名称',
            'licence' => '证件',
            'licence_image' => '附件',
            'corporation' => '联系人',
            'mobile' => '联系电话',
        ];
    }
}

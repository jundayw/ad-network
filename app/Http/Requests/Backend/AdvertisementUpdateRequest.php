<?php

namespace App\Http\Requests\Backend;

use App\Http\Requests\FormRequest;

class AdvertisementUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'type' => ['required'],
            'name' => ['required', "unique:advertisement,name,{$this->get('id')}"],
            'licence' => ['required', "unique:advertisement,licence,{$this->get('id')}"],
            'licence_image' => ['required'],
            'corporation' => ['required'],
            'mobile' => ['required'],
            'audit' => ['required'],
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
            'type' => '名称',
            'name' => '公司名称/真实姓名',
            'licence' => '营业执照编号/身份证编号',
            'licence_image' => '营业执照附件/身份证附件',
            'corporation' => '联系人',
            'mobile' => '联系电话',
            'audit' => '审核状态',
        ];
    }
}

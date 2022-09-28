<?php

namespace App\Http\Requests\Backend;

use App\Http\Requests\FormRequest;

class DepositCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric'],
            'type' => ['required'],
            'remark' => ['required'],
            'id' => ['required', 'numeric'],
            'deposit' => ['required'],
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
            'amount' => '交易金额',
            'type' => '交易类型',
            'remark' => '交易摘要',
            'id' => '标识主键',
            'deposit' => '标识',
        ];
    }
}

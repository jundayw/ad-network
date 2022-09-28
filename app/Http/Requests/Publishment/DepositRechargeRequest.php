<?php

namespace App\Http\Requests\Publishment;

use App\Http\Requests\FormRequest;

class DepositRechargeRequest extends FormRequest
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
            'payment' => ['required'],
            'remark' => ['required'],
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
            'amount' => '金额',
            'payment' => '交易渠道',
            'remark' => '交易摘要',
        ];
    }
}

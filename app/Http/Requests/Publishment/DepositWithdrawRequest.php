<?php

namespace App\Http\Requests\Publishment;

use App\Http\Requests\FormRequest;

class DepositWithdrawRequest extends FormRequest
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
            'remark' => '交易摘要',
        ];
    }
}

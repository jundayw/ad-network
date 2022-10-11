<?php

namespace App\Http\Requests\Advertisement;

use App\Http\Requests\FormRequest;

class ElementUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $rules = [
            'title' => ['required'],
            'release_begin' => ['required', 'before_or_equal:release_finish'],
            'release_finish' => ['required', 'after_or_equal:release_begin'],
            'period_begin' => ['required', 'before_or_equal:period_finish'],
            'period_finish' => ['required', 'after_or_equal:period_begin'],
        ];

        $rate = match ($this->get('type')) {
            'cpc' => config('system.cpc_min_amount'),
            'cpm' => config('system.cpm_min_amount'),
            'cpv' => config('system.cpv_min_amount'),
            'cpa' => config('system.cpa_min_amount'),
            'cps' => config('system.cps_min_amount'),
        };

        $rules['rate'] = ['required', 'numeric', "gte:{$rate}"];

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
            'title' => '名称',
            'release_begin' => '开始时间',
            'release_finish' => '截止时间',
            'period_begin' => '开始时段',
            'period_finish' => '截止时段',
            'rate' => '出价',
        ];
    }
}

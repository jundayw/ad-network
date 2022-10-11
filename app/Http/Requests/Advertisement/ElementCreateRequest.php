<?php

namespace App\Http\Requests\Advertisement;

use App\Http\Requests\FormRequest;

class ElementCreateRequest extends FormRequest
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
            'program' => ['required', 'gte:1'],
            'release_begin' => ['required', 'before_or_equal:release_finish'],
            'release_finish' => ['required', 'after_or_equal:release_begin'],
            'period_begin' => ['required', 'before_or_equal:period_finish'],
            'period_finish' => ['required', 'after_or_equal:period_begin'],
            'type' => ['required'],
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
            'program' => '广告计划',
            'release_begin' => '开始时间',
            'release_finish' => '截止时间',
            'period_begin' => '开始时段',
            'period_finish' => '截止时段',
            'type' => '出价方式',
            'rate' => '出价',
        ];
    }
}

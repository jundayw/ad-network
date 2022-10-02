<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visits extends Model
{
    use SoftDeletes;

    protected $table = 'visits';

    public function getOrigin(?string $value = null, ?string $default = '--'): string|array
    {
        return $this->getEnumeration([
            'UNION' => '联盟广告',
            'LOCAL' => '本地广告',
        ], $value, $default);
    }

    protected function origin(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => strtolower($value),
            set: fn($value, $attributes) => strtoupper($value),
        );
    }

    public function getDevice(?string $value = null, ?string $default = '--'): string|array
    {
        return $this->getEnumeration([
            'PC' => '电脑端',
            'MOBILE' => '移动端',
        ], $value, $default);
    }

    protected function device(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => strtolower($value),
            set: fn($value, $attributes) => strtoupper($value),
        );
    }

    public function getType(?string $value = null, ?string $default = '--'): string|array
    {
        return $this->getEnumeration([
            'SINGLE' => '单图',
            'MULTIGRAPH' => '多图',
            'POPUP' => '弹窗',
            'FLOAT' => '悬浮',
            'COUPLET' => '对联',
            'EXCHANGE' => '显示换量广告',
            'DEFAULT' => '显示本地广告',
            'UNION' => '显示联盟广告',
            'FIXED' => '显示公益广告',
            'HIDDEN' => '隐藏广告位',
        ], $value, $default);
    }

    protected function type(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => strtolower($value),
            set: fn($value, $attributes) => strtoupper($value),
        );
    }

    public function getCharging(?string $value = null, ?string $default = '--'): string|array
    {
        return $this->getEnumeration([
            'DEFAULT' => '智能',
            'CPC' => '按点击付费(CPC)',
            'CPM' => '按千次IP展示付费(CPM)',
            'CPV' => '按千次页面展示付费(CPV)',
            'CPA' => '按指定的行为付费(CPA)',
            'CPS' => '按佣金付费(CPS)',
        ], $value, $default);
    }

    protected function charging(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => strtolower($value),
            set: fn($value, $attributes) => strtoupper($value),
        );
    }
}

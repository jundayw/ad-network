<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vacation extends Model
{
    use SoftDeletes;

    protected $table = 'vacation';

    public function getType(?string $value = null, ?string $default = '--'): string|array
    {
        return $this->getEnumeration([
            'CPC' => 'CPC',
            'CPM' => 'CPM',
            'CPV' => 'CPV',
            'CPA' => 'CPA',
            'CPS' => 'CPS',
        ], $value, $default);
    }

    protected function type(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => strtolower($value),
            set: fn($value, $attributes) => strtoupper($value),
        );
    }

    public function getVacant(?string $value = null, ?string $default = '--'): string|array
    {
        return $this->getEnumeration([
            'EXCHANGE' => '显示换量广告',
            'DEFAULT' => '显示本地广告',
            'UNION' => '显示联盟广告',
            'FIXED' => '显示公益广告',
            'HIDDEN' => '隐藏广告位',
        ], $value, $default);
    }

    protected function vacant(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => strtolower($value),
            set: fn($value, $attributes) => strtoupper($value),
        );
    }
}

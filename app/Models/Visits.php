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
            'DEFAULT' => '智能',
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

    public function getState(?string $value = null, ?string $default = '--'): string|array
    {
        return $this->getEnumeration([
            'NORMAL' => '新访客',
            'DISABLE' => '老访客',
        ], $value, $default);
    }

    protected function state(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => strtolower($value),
            set: fn($value, $attributes) => strtoupper($value),
        );
    }
}

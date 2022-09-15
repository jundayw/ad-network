<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class Industry extends Model
{
    use SoftDeletes;

    protected $table = 'industry';

    public function getState(?string $value = null, ?string $default = '--'): string|array
    {
        return $this->getEnumeration([
            'NORMAL' => '正常',
            'DISABLE' => '禁用',
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

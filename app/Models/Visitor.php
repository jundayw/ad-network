<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visitor extends Model
{
    use SoftDeletes;

    protected $table = 'visitor';

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
}

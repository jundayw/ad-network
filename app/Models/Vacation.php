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
            'CPC' => '按点击付费(CPC)',
            'CPM' => '按千次IP展示付费(CPM)',
            'CPV' => '按千次页面展示付费(CPV)',
            'CPA' => '按指定的行为付费(CPA)',
            'CPS' => '按佣金付费(CPS)',
        ], $value, $default);
    }

    protected function type(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => strtolower($value),
            set: fn($value, $attributes) => strtoupper($value),
        );
    }

    protected function rate(): Attribute
    {
        return $this->getMoney();
    }
}

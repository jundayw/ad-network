<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class System extends Model
{
    use SoftDeletes;

    protected $table = 'system';

    protected function key(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => strtolower($value),
            set: fn($value, $attributes) => strtoupper($value),
        );
    }

    public function getValue($value = null, ?string $default = '--')
    {
        return match ($this->getAttribute('type')) {
                'radio', 'select' => json_decode($this->getAttribute('options'))->{$this->getAttribute('value')},
                'checkbox' => implode(',', array_values(array_filter(json_decode($this->getAttribute('options'), true), function ($value, $key) {
                    return in_array($key, $this->getAttribute('value'));
                }, ARRAY_FILTER_USE_BOTH))),
                default => $value
            } ?? $default;
    }

    protected function value(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => $attributes['type'] == 'CHECKBOX' ? explode(md5(','), $value) : $value,
            set: fn($value, $attributes) => is_array($value) ? implode(md5(','), $value) : $value,
        );
    }

    public function getType(?string $value = null, ?string $default = '--'): string|array
    {
        return $this->getEnumeration([
            'TEXT' => '文本框',
            'RADIO' => '单选框',
            'SELECT' => '下拉框',
            'CHECKBOX' => '复选框',
            'TEXTAREA' => '多行文本框',
            'DATETIMEPICKER' => '日期时间控件',
            'DATEPICKER' => '日期控件',
            'TIMEPICKER' => '时间控件',
            'FILE' => '上传控件',
        ], $value, $default);
    }

    protected function type(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => strtolower($value),
            set: fn($value, $attributes) => strtoupper($value),
        );
    }

    public function getModifiable(?string $value = null, ?string $default = '--'): string|array
    {
        return $this->getEnumeration([
            'NORMAL' => '允许修改',
            'DISABLE' => '禁止修改',
        ], $value, $default);
    }

    protected function modifiable(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => strtolower($value),
            set: fn($value, $attributes) => strtoupper($value),
        );
    }
}

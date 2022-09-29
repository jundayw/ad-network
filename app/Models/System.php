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
                'radio', 'select' => array_key_exists($this->getAttribute('value'), $this->getAttribute('options')) ? $this->getAttribute('options')[$this->getAttribute('value')] : null,
                'checkbox' => implode(',', array_values(array_filter($this->getAttribute('options'), function ($value, $key) {
                    return in_array($key, $this->getAttribute('value'));
                }, ARRAY_FILTER_USE_BOTH))),
                default => $value
            } ?? $default;
    }

    protected function value(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => in_array(strtolower($attributes['type']), ['checkbox']) ? explode(md5(','), $value) : $value,
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
            'STATIC' => '静态文本',
        ], $value, $default);
    }

    protected function type(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => strtolower($value),
            set: fn($value, $attributes) => strtoupper($value),
        );
    }

    protected function options(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => in_array(strtolower($attributes['type']), ['radio', 'select', 'checkbox']) ? json_decode($value, true) : $value,
            set: fn($value, $attributes) => $value,
        );
    }
}

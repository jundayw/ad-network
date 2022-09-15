<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Policy extends Model
{
    use SoftDeletes;

    protected $table = 'policy';

    public function getType(?string $value = null, ?string $default = '--'): string|array
    {
        return $this->getEnumeration([
            'NAVIGATION' => '菜单',
            'PAGE' => '页面',
            'NODE' => '节点',
        ], $value, $default);
    }

    protected function type(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => strtolower($value),
            set: fn($value, $attributes) => strtoupper($value),
        );
    }

    protected function statement(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => explode(',', $value),
            set: fn($value, $attributes) => implode(',', $value),
        );
    }

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

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class, 'module_id', 'id')->withDefault();
    }

    public function policies(): HasMany
    {
        return $this->hasMany(Policy::class, 'pid', 'id');
    }

    public function policy(): BelongsTo
    {
        return $this->belongsTo(Policy::class, 'pid', 'id')->withDefault();
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Site extends Model
{
    use SoftDeletes;

    protected $table = 'site';

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

    public function getProtocol(?string $value = null, ?string $default = '--'): string|array
    {
        return $this->getEnumeration([
            'http://' => 'http://',
            'https://' => 'https://',
        ], $value, $default);
    }

    protected function protocol(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => strtolower($value),
        );
    }

    public function getType(?string $value = null, ?string $default = '--'): string|array
    {
        return $this->getEnumeration([
            'txt' => '文件验证',
            'html' => 'HTML标签验证',
        ], $value, $default);
    }

    public function industry(): BelongsTo
    {
        return $this->belongsTo(Industry::class)->withDefault();
    }

    public function channel(): HasMany
    {
        return $this->hasMany(Channel::class);
    }
}

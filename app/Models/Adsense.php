<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Adsense extends Model
{
    use SoftDeletes;

    protected $table = 'adsense';

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

    // 展现类型{SINGLE:单图}{MULTIGRAPH:多图}{POPUP:弹窗}{FLOAT:悬浮}{COUPLET:对联}
    public function getType(?string $value = null, ?string $default = '--'): string|array
    {
        return $this->getEnumeration([
            'SINGLE' => '单图',
            'MULTIGRAPH' => '多图',
            'POPUP' => '弹窗',
            'FLOAT' => '悬浮',
            'COUPLET' => '对联',
        ], $value, $default);
    }

    protected function type(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => strtolower($value),
            set: fn($value, $attributes) => strtoupper($value),
        );
    }

    // 空闲设置{EXCHANGE:显示换量广告}{DEFAULT:显示默认广告}{UNION:显示联盟广告}{FIXED:固定占位符}{HIDDEN:隐藏广告位}
    public function getVacant(?string $value = null, ?string $default = '--'): string|array
    {
        return $this->getEnumeration([
            'EXCHANGE' => '显示换量广告',
            'DEFAULT' => '显示本地广告',
            'UNION' => '显示联盟广告',
            'FIXED' => '固定占位符',
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

    public function getState(?string $value = null, ?string $default = '--'): string|array
    {
        return $this->getEnumeration([
            'NORMAL' => '投放中',
            'DISABLE' => '暂停投放',
        ], $value, $default);
    }

    protected function state(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => strtolower($value),
            set: fn($value, $attributes) => strtoupper($value),
        );
    }

    public function scopePublishment(Builder $builder, Request $request): Builder
    {
        return $builder->where('publishment_id', $request->user()->getAttribute('publishment_id'));
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class)->withDefault();
    }

    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class)->withDefault();
    }

    public function size(): BelongsTo
    {
        return $this->belongsTo(Size::class)->withDefault();
    }
}

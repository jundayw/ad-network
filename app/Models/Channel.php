<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Channel extends Model
{
    use SoftDeletes;

    protected $table = 'channel';

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

    public function scopePublishment(Builder $builder, Request $request): Builder
    {
        return $builder->where('publishment_id', $request->user()->getAttribute('publishment_id'));
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class)->withDefault();
    }
}

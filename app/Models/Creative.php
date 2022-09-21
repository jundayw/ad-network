<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Creative extends Model
{
    use SoftDeletes;

    protected $table = 'creative';

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

    public function scopeAdvertisement(Builder $builder, Request $request): Builder
    {
        return $builder->where('advertisement_id', $request->user()->getAttribute('advertisement_id'));
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class)->withDefault();
    }

    public function element(): BelongsTo
    {
        return $this->belongsTo(Element::class)->withDefault();
    }

    public function size(): BelongsTo
    {
        return $this->belongsTo(Size::class)->withDefault();
    }
}

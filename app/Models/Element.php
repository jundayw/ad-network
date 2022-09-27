<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Element extends Model
{
    use SoftDeletes;

    protected $table = 'element';

    public function getType(?string $value = null, ?string $default = '--'): string|array
    {
        return $this->getEnumeration([
            'CPC' => 'CPC',
            'CPM' => 'CPM',
            'CPA' => 'CPA',
            'CPS' => 'CPS',
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

    public function creative(): HasMany
    {
        return $this->hasMany(Creative::class);
    }

    public function advertisements(): BelongsTo
    {
        return $this->belongsTo(Advertisement::class, 'advertisement_id')->withDefault();
    }
}

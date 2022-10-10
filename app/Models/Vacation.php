<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
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

    protected function originRate(): Attribute
    {
        return $this->getMoney();
    }

    protected function rate(): Attribute
    {
        return $this->getMoney();
    }

    public function size(): BelongsTo
    {
        return $this->belongsTo(Size::class)->withTrashed();
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class)->withTrashed();
    }

    public function element(): BelongsTo
    {
        return $this->belongsTo(Element::class)->withTrashed();
    }

    public function creative(): BelongsTo
    {
        return $this->belongsTo(Creative::class)->withTrashed();
    }

    public function visits(): HasOne
    {
        return $this->hasOne(Visits::class)->withTrashed();
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class)->withTrashed();
    }

    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class)->withTrashed();
    }

    public function adsense(): BelongsTo
    {
        return $this->belongsTo(Adsense::class)->withTrashed();
    }
}

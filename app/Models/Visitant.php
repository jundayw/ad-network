<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visitant extends Model
{
    use SoftDeletes;

    protected $table = 'visitant';

    public function getType(?string $value = null, ?string $default = '--'): string|array
    {
        return $this->getEnumeration([
            'SINGLE' => '单图',
            'MULTIGRAPH' => '多图',
            'POPUP' => '弹窗',
            'FLOAT' => '悬浮',
            'COUPLET' => '对联',
            'EXCHANGE' => '显示换量广告',
            'DEFAULT' => '显示本地广告',
            'UNION' => '显示联盟广告',
            'FIXED' => '显示公益广告',
            'HIDDEN' => '隐藏广告位',
        ], $value, $default);
    }

    protected function type(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => strtolower($value),
            set: fn($value, $attributes) => strtoupper($value),
        );
    }

    public function visits(): BelongsTo
    {
        return $this->belongsTo(Visits::class)->withTrashed()->withDefault();
    }

    public function size(): BelongsTo
    {
        return $this->belongsTo(Size::class)->withTrashed()->withDefault();
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class)->withTrashed()->withDefault();
    }

    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class)->withTrashed()->withDefault();
    }

    public function adsense(): BelongsTo
    {
        return $this->belongsTo(Adsense::class)->withTrashed()->withDefault();
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class)->withTrashed()->withDefault();
    }

    public function element(): BelongsTo
    {
        return $this->belongsTo(Element::class)->withTrashed()->withDefault();
    }

    public function creative(): BelongsTo
    {
        return $this->belongsTo(Creative::class)->withTrashed()->withDefault();
    }
}

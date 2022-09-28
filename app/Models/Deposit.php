<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deposit extends Model
{
    use SoftDeletes;

    protected $table = 'deposit';

    public function getType(?string $value = null, ?string $default = '--'): string|array
    {
        return $this->getEnumeration([
            'RECHARGE' => '充值',
            'WITHDRAW' => '提现',
        ], $value, $default);
    }

    protected function type(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => strtolower($value),
            set: fn($value, $attributes) => strtoupper($value),
        );
    }

    public function getPayment(?string $value = null, ?string $default = '--'): string|array
    {
        return $this->getEnumeration([
            'OFFLINE' => '线下',
        ], $value, $default);
    }

    protected function payment(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => strtolower($value),
            set: fn($value, $attributes) => strtoupper($value),
        );
    }

    protected function amount(): Attribute
    {
        return $this->getMoney();
    }

    public function getState(?string $value = null, ?string $default = '--'): string|array
    {
        return $this->getEnumeration([
            'SUCCESS' => '成功',
            'FAILURE' => '失败',
            'WAIT' => '待审核',
            'INIT' => '初始化',
        ], $value, $default);
    }

    protected function state(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => strtolower($value),
            set: fn($value, $attributes) => strtoupper($value),
        );
    }

    public function depositer(?string $value = null, ?string $default = '--'): string|array
    {
        return $this->getEnumeration([
            'advertisement' => '广告主',
            'publishment' => '流量主',
        ], $value, $default);
    }

    public function deposit(): MorphTo
    {
        return $this->morphTo();
    }
}

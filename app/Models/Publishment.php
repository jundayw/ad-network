<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class Publishment extends Model
{
    use SoftDeletes;

    protected $table = 'publishment';

    public function getType(?string $value = null, ?string $default = '--'): string|array
    {
        return $this->getEnumeration([
            'COMPANY' => '公司',
            'PERSONAL' => '个人',
        ], $value, $default);
    }

    protected function type(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => strtolower($value),
            set: fn($value, $attributes) => strtoupper($value),
        );
    }

    public function getWallet(?string $value = null, ?string $default = '--'): string|array
    {
        return $this->getEnumeration([
            'ALIPAY' => '支付宝',
            'WECHAT' => '微信',
            'USDT' => 'USDT',
        ], $value, $default);
    }

    protected function wallet(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => strtolower($value),
            set: fn($value, $attributes) => strtoupper($value),
        );
    }

    // 审核状态{INIT:初始化}{WAIT:待审核}{SUCCESS:成功}{FAILURE:失败}{STOP:终止合作}
    public function getAudit(?string $value = null, ?string $default = '--'): string|array
    {
        return $this->getEnumeration([
            'INIT' => '初始化',
            'WAIT' => '待审核',
            'SUCCESS' => '成功',
            'FAILURE' => '失败',
            'STOP' => '终止合作',
        ], $value, $default);
    }

    protected function audit(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => strtolower($value),
            set: fn($value, $attributes) => strtoupper($value),
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

    protected function total(): Attribute
    {
        return $this->getMoney();
    }

    protected function balance(): Attribute
    {
        return $this->getMoney();
    }

    protected function frozen(): Attribute
    {
        return $this->getMoney();
    }
}

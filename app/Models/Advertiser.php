<?php

namespace App\Models;

use App\Models\Policy as PolicyModel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Jundayw\LaravelPolicy\Policy;
use Jundayw\LaravelPolicy\PolicyContract;

class Advertiser extends Authenticate implements PolicyContract
{
    use SoftDeletes;
    use Policy;

    protected $table = 'advertiser';

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

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function advertisement(): BelongsTo
    {
        return $this->belongsTo(Advertisement::class)->withDefault();
    }

    /**
     * @param string $ability
     * @param mixed $arguments
     * @return string[]
     */
    public function getPolicies(string $ability, mixed $arguments): array
    {
        $key = sprintf('%s::%s', static::class, $this->getAttribute('role_id'));
        return Cache::rememberForever($key, function () {
            $policies = $this->role()->with([
                'rolePolicies' => function ($query) {
                    $query->where('state', 'NORMAL');
                },
            ])->first();
            return $policies->getRelation('rolePolicies')
                ->pluck('statement')
                ->flatten()
                ->toArray();
        });
    }
}

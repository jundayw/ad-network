<?php

namespace App\Entities\Analysis;

use App\Models\Publisher;
use Illuminate\Support\Collection;

class SecurityEntity extends Entity
{
    public function __construct(
        private readonly Publisher $publisher,
    )
    {
        //
    }

    public function filter(Collection $request): bool
    {
        if (config('system.filter_security_ip', 'disable') == 'disable') {
            return false;
        }

        $key       = password(static::class, $request->get('pid', 0));
        $publisher = cache()->remember($key, 5 * 60, function () use ($request) {
            return $this->publisher->where('publishment_id', $request->get('pid'))->get()->pluck('last_ip');
        });

        return $publisher->contains($request->get('ip'));
    }
}

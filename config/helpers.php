<?php

return [
    'assets' => [
        'domain' => [
            env('ASSETS_DOMAIN', '//assets.test'),
        ],
        'dns-prefetch' => [
            env('ASSETS_DOMAIN', '//assets.test'),
        ],
    ],
    'gzip' => env('HELPS_GZIP', false),
    'excepts' => explode(',', env('HELPS_EXCEPTS', '')),
];

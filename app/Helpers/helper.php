<?php

/**
 * 获取静态资源
 * @param string $file
 * @param boolean|string $local
 * @return string
 */
function H(string $file = '', bool|string $local = false): string
{
    $domains = config('helpers.assets.domain', []);

    if ($local === false) {
        $domain = \Illuminate\Support\Arr::random($domains);
    } elseif ($local === true) {
        $domain = app('request')->getSchemeAndHttpHost();
    } else {
        $domain = $local;
    }

    return sprintf('%s/%s?v=%s', rtrim($domain, '/'), ltrim($file, '/'), get_timestamp());
}

/**
 * 通配符正则校验
 * @param string $pattern
 * @param string $value
 * @return bool
 * @example wildcard('admin.*','admin.login')
 */
function wildcard(string $pattern, string $value): bool
{
    if ($pattern == $value) {
        return true;
    }

    $pattern = preg_quote($pattern, '#');
    $pattern = str_replace('\*', '.*', $pattern);

    if (preg_match('#^' . $pattern . '\z#u', $value) === 1) {
        return true;
    }

    return false;
}

/**
 * 管道方法
 * @param mixed $passable
 * @param array|mixed $pipes
 * @param \Closure|null $destination
 * @return mixed
 */
function pipeline(mixed $passable, mixed $pipes, Closure $destination = null): mixed
{
    $pipeline = app(\Illuminate\Pipeline\Pipeline::class)->send($passable)->through($pipes);

    if ($destination) {
        return $pipeline->then($destination);
    }

    return $pipeline->thenReturn();
}

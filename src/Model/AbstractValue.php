<?php

declare(strict_types=1);

namespace DavidGarcia\ValueObject\Model;

abstract class AbstractValue
{
    private static array $cache = [];

    protected static function cacheRetrieve($key): ?object
    {
        return self::$cache[self::getCacheKey($key)] ?? null;
    }

    protected static function cacheStore($key, object $object): void
    {
        self::$cache[self::getCacheKey($key)] = $object;
    }

    private static function getCacheKey($key): string
    {
        return sprintf('%s', $key);
    }
}

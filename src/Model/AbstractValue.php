<?php

declare(strict_types=1);

namespace DavidGarcia\ValueObject\Model;

abstract class AbstractValue
{
    private static array $cache = [];

    protected static function cacheRetrieve($key): ?object
    {
        if (array_key_exists($key, self::$cache)) {
            return self::$cache[$key];
        }

        return null;
    }

    protected static function cacheStore($key, object $object): void
    {
        self::$cache[$key] = $object;
    }
}

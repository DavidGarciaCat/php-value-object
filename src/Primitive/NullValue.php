<?php

declare(strict_types=1);

namespace DavidGarcia\ValueObject\Primitive;

use DavidGarcia\ValueObject\Exception\InvalidValueException;

class NullValue extends AbstractValue
{
    private function __construct()
    {
    }

    /**
     * Creates the value object.
     *
     * @return NullValue The value object
     */
    public static function create(): self
    {
        return new self();
    }

    /**
     * Exposes the stored NULL value.
     *
     * @return NULL The NULL value
     */
    public function getValue()
    {
        return null;
    }
}

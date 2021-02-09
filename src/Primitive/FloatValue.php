<?php

declare(strict_types=1);

namespace DavidGarcia\ValueObject\Primitive;

class FloatValue extends AbstractValue
{
    private float $value;

    private function __construct(float $value, bool $cache)
    {
        $this->value = $value;

        if ($cache) {
            self::cacheStore($value, $this);
        }
    }

    /**
     * Creates the value object.
     *
     * @param float $value The float value
     * @param bool  $cache Cache the value so we reuse the same object
     *
     * @return FloatValue The value object
     */
    public static function create(float $value, bool $cache = false): self
    {
        $object = $cache ? parent::cacheRetrieve($value) : null;

        if (null === $object) {
            $object = new self($value, $cache);
        }

        return $object;
    }

    /**
     * Exposes the stored float value.
     *
     * @return float The float value
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * Compares if the value of a given object matches with this object.
     *
     * @param FloatValue $object The input object to be compared
     *
     * @return bool TRUE if the value matches; FALSE otherwise
     */
    public function equals(FloatValue $object): bool
    {
        return $this->getValue() === $object->getValue();
    }
}

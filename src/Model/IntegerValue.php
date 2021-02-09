<?php

declare(strict_types=1);

namespace DavidGarcia\ValueObject\Model;

class IntegerValue extends AbstractValue
{
    private int $value;

    private function __construct(int $value, bool $cache)
    {
        $this->value = $value;

        if ($cache) {
            self::cacheStore($value, $this);
        }
    }

    /**
     * Creates the value object.
     *
     * @param int  $value The integer value
     * @param bool $cache Cache the value so we reuse the same object
     *
     * @return IntegerValue The value object
     */
    public static function create(int $value, bool $cache = false): self
    {
        $object = $cache ? parent::cacheRetrieve($value) : null;

        if (null === $object) {
            $object = new self($value, $cache);
        }

        return $object;
    }

    /**
     * Exposes the stored integer value.
     *
     * @return int The integer value
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * Compares if the value of a given object matches with this object.
     *
     * @param IntegerValue $object The input object to be compared
     *
     * @return bool TRUE if the value matches; FALSE otherwise
     */
    public function equals(IntegerValue $object): bool
    {
        return $this->getValue() === $object->getValue();
    }
}

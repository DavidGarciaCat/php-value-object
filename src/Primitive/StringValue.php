<?php

declare(strict_types=1);

namespace DavidGarcia\ValueObject\Primitive;

use DavidGarcia\ValueObject\Exception\InvalidValueException;

class StringValue extends AbstractValue
{
    private string $value;

    private function __construct(string $value, bool $cache)
    {
        $this->value = $value;

        if ($cache) {
            self::cacheStore($value, $this);
        }
    }

    /**
     * Exposes the stored string value.
     *
     * @return string The string value
     */
    public function __toString(): string
    {
        return $this->getValue();
    }

    /**
     * Creates the value object.
     *
     * @param string $value The string value
     * @param bool   $cache Cache the value so we reuse the same object
     *
     * @throws InvalidValueException The initial validation of the value has failed
     *
     * @return StringValue The value object
     */
    public static function create(string $value, bool $cache = false): self
    {
        if ('' === trim($value)) {
            throw new InvalidValueException('String value cannot be empty');
        }

        $object = $cache ? parent::cacheRetrieve($value) : null;

        if (null === $object) {
            $object = new self($value, $cache);
        }

        return $object;
    }

    /**
     * Exposes the stored string value.
     *
     * @return string The string value
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Compares if the value of a given object matches with this object.
     *
     * @param StringValue $object The input object to be compared
     *
     * @return bool TRUE if the value matches; FALSE otherwise
     */
    public function equals(StringValue $object): bool
    {
        return $this->getValue() === $object->getValue();
    }
}

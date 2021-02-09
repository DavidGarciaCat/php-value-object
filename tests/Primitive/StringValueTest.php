<?php

declare(strict_types=1);

namespace DavidGarcia\Tests\ValueObject\Primitive;

use DavidGarcia\ValueObject\Exception\InvalidValueException;
use DavidGarcia\ValueObject\Primitive\StringValue;
use PHPUnit\Framework\TestCase;

class StringValueTest extends TestCase
{
    public function testExposeStringValue(): void
    {
        $object = StringValue::create('qwerty');

        self::assertEquals('qwerty', (string) $object);
        self::assertEquals('qwerty', $object->getValue());
    }

    public function testSameStringObject(): void
    {
        $object1 = StringValue::create('qwerty');
        $object2 = StringValue::create('qwerty');

        self::assertNotSame($object1, $object2);
    }

    public function testExposeCachedStringValue(): void
    {
        $object = StringValue::create('qwerty', true);

        self::assertEquals('qwerty', (string) $object);
        self::assertEquals('qwerty', $object->getValue());
    }

    public function testSameCachedStringObject(): void
    {
        $object1 = StringValue::create('qwerty', true);
        $object2 = StringValue::create('qwerty', true);

        self::assertSame($object1, $object2);
    }

    public function testCheckSameStringValue(): void
    {
        $object1 = StringValue::create('qwerty');
        $object2 = StringValue::create('qwerty');

        self::assertTrue($object1->equals($object2));
    }

    public function testCheckSameCachedStringValue(): void
    {
        $object1 = StringValue::create('qwerty', true);
        $object2 = StringValue::create('qwerty', true);

        self::assertTrue($object1->equals($object2));
    }

    public function testEmptyString(): void
    {
        $this->expectException(InvalidValueException::class);

        StringValue::create('');
    }
}

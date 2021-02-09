<?php

declare(strict_types=1);

namespace DavidGarcia\Tests\ValueObject\Model;

use DavidGarcia\ValueObject\Model\FloatValue;
use PHPUnit\Framework\TestCase;

class FloatValueTest extends TestCase
{
    public function testExposeFloatValue(): void
    {
        $object = FloatValue::create(123.456);

        self::assertEquals(123.456, $object->getValue());
    }

    public function testSameStringObject(): void
    {
        $object1 = FloatValue::create(123.456);
        $object2 = FloatValue::create(123.456);

        self::assertNotSame($object1, $object2);
    }

    public function testExposeCachedFloatValue(): void
    {
        $object = FloatValue::create(123.456, true);

        self::assertEquals(123.456, $object->getValue());
    }

    public function testSameCachedStringObject(): void
    {
        $object1 = FloatValue::create(123.456, true);
        $object2 = FloatValue::create(123.456, true);

        self::assertSame($object1, $object2);
    }

    public function testCheckSameFloatValue(): void
    {
        $object1 = FloatValue::create(123.456);
        $object2 = FloatValue::create(123.456);

        self::assertTrue($object1->equals($object2));
    }

    public function testCheckSameCachedFloatValue(): void
    {
        $object1 = FloatValue::create(123.456, true);
        $object2 = FloatValue::create(123.456, true);

        self::assertTrue($object1->equals($object2));
    }
}

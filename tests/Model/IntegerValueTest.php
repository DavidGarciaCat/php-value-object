<?php

declare(strict_types=1);

namespace DavidGarcia\Tests\ValueObject\Model;

use DavidGarcia\ValueObject\Model\IntegerValue;
use PHPUnit\Framework\TestCase;

class IntegerValueTest extends TestCase
{
    public function testExposeIntegerValue(): void
    {
        $object = IntegerValue::create(123);

        self::assertEquals(123, $object->getValue());
    }

    public function testSameStringObject(): void
    {
        $object1 = IntegerValue::create(123);
        $object2 = IntegerValue::create(123);

        self::assertNotSame($object1, $object2);
    }

    public function testExposeCachedIntegerValue(): void
    {
        $object = IntegerValue::create(123, true);

        self::assertEquals(123, $object->getValue());
    }

    public function testSameCachedStringObject(): void
    {
        $object1 = IntegerValue::create(123, true);
        $object2 = IntegerValue::create(123, true);

        self::assertSame($object1, $object2);
    }

    public function testCheckSameIntegerValue(): void
    {
        $object1 = IntegerValue::create(123);
        $object2 = IntegerValue::create(123);

        self::assertTrue($object1->equals($object2));
    }

    public function testCheckSameCachedIntegerValue(): void
    {
        $object1 = IntegerValue::create(123, true);
        $object2 = IntegerValue::create(123, true);

        self::assertTrue($object1->equals($object2));
    }
}

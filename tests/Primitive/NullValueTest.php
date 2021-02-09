<?php

declare(strict_types=1);

namespace DavidGarcia\Tests\ValueObject\Primitive;

use DavidGarcia\ValueObject\Primitive\NullValue;
use PHPUnit\Framework\TestCase;

class NullValueTest extends TestCase
{
    public function testExposeNullValue(): void
    {
        $object = NullValue::create();

        self::assertNull($object->getValue());
    }
}

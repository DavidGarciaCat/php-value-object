<?php

declare(strict_types=1);

namespace DavidGarcia\Tests\ValueObject\Model;

use DavidGarcia\ValueObject\Model\NullValue;
use PHPUnit\Framework\TestCase;

class NullValueTest extends TestCase
{
    public function testExposeNullValue(): void
    {
        $object = NullValue::create();

        self::assertNull($object->getValue());
    }
}

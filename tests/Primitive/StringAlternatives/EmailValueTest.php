<?php

declare(strict_types=1);

namespace DavidGarcia\Tests\ValueObject\Primitive\StringAlternatives;

use DavidGarcia\ValueObject\Exception\InvalidValueException;
use DavidGarcia\ValueObject\Primitive\StringAlternatives\EmailValue;
use PHPUnit\Framework\TestCase;

class EmailValueTest extends TestCase
{
    public function testExposeStringValue(): void
    {
        $object = EmailValue::create('inbox@gmail.com');

        self::assertEquals('inbox@gmail.com', (string) $object);
        self::assertEquals('inbox@gmail.com', $object->getValue());
    }

    public function testSameStringObject(): void
    {
        $object1 = EmailValue::create('inbox@gmail.com');
        $object2 = EmailValue::create('inbox@gmail.com');

        self::assertNotSame($object1, $object2);
    }

    public function testExposeCachedStringValue(): void
    {
        $object = EmailValue::create('inbox@gmail.com', true);

        self::assertEquals('inbox@gmail.com', (string) $object);
        self::assertEquals('inbox@gmail.com', $object->getValue());
    }

    public function testSameCachedStringObject(): void
    {
        $object1 = EmailValue::create('inbox@gmail.com', true);
        $object2 = EmailValue::create('inbox@gmail.com', true);

        self::assertSame($object1, $object2);
    }

    public function testCheckSameStringValue(): void
    {
        $object1 = EmailValue::create('inbox@gmail.com');
        $object2 = EmailValue::create('inbox@gmail.com');

        self::assertTrue($object1->equals($object2));
    }

    public function testCheckSameCachedStringValue(): void
    {
        $object1 = EmailValue::create('inbox@gmail.com', true);
        $object2 = EmailValue::create('inbox@gmail.com', true);

        self::assertTrue($object1->equals($object2));
    }

    public function testEmptyString(): void
    {
        $this->expectException(InvalidValueException::class);

        EmailValue::create('');
    }

    public function testRfcEmailValidation(): void
    {
        $this->expectException(InvalidValueException::class);

        EmailValue::create('inbox [at] domain [dot] com');
    }

    public function testDnsEmailValidation(): void
    {
        $domain = sprintf('%s.%s', str_repeat(chr(rand(97, 122)), 20), str_repeat(chr(rand(97, 122)), 3));
        $email = sprintf('inbox@%s', $domain);

        $this->expectException(InvalidValueException::class);

        EmailValue::create($email);
    }
}

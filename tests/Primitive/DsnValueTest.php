<?php

declare(strict_types=1);

namespace DavidGarcia\Tests\ValueObject\Primitive;

use DavidGarcia\ValueObject\Exception\InvalidValueException;
use DavidGarcia\ValueObject\Primitive\DsnValue;
use PHPUnit\Framework\TestCase;

class DsnValueTest extends TestCase
{
    private const DSN = 'http://user:pass@www.domain.com:4443/Resource?key=value#anchor';

    private DsnValue $object;

    protected function setUp(): void
    {
        $this->object = DsnValue::create(self::DSN);
    }

    public function testExposeOriginalValue(): void
    {
        self::assertEquals(self::DSN, $this->object->getValue());
    }

    public function testExposeSanitizedValue(): void
    {
        $dsnString = self::DSN;
        $sanitized = 'http://www.domain.com:4443/Resource?key=value#anchor';

        self::assertEquals($sanitized, (DsnValue::create($dsnString))->getSanitizedValue());
    }

    public function testExposeScheme(): void
    {
        self::assertEquals('http', $this->object->getScheme());
    }

    public function testExposeUsername(): void
    {
        self::assertEquals('user', $this->object->getUser());
    }

    public function testExposePassword(): void
    {
        self::assertEquals('pass', $this->object->getPass());
    }

    public function testExposeAuthorisationBasicToken(): void
    {
        self::assertEquals(base64_encode('user:pass'), $this->object->getAuthorisationBasicToken());
    }

    public function testExposeEmptyAuthorisationBasicToken(): void
    {
        $dsnObject = DsnValue::create('http://www.domain.com/Resource?key=value#anchor');

        self::assertNull($dsnObject->getAuthorisationBasicToken());
    }

    public function testExposeHost(): void
    {
        self::assertEquals('www.domain.com', $this->object->getHost());
    }

    public function testExposePort(): void
    {
        self::assertEquals(4443, $this->object->getPort());
    }

    public function testExposeByDefaultPort(): void
    {
        $dsnObject = DsnValue::create('http://www.domain.com/Resource?key=value#anchor');

        self::assertNull($dsnObject->getPort());
    }

    public function testExposeResourcePath(): void
    {
        self::assertEquals('/Resource', $this->object->getPath());
    }

    public function testExposeQueryString(): void
    {
        self::assertEquals(['key' => 'value'], $this->object->getQuery());
    }

    public function testExposeAnchorFragment(): void
    {
        self::assertEquals('anchor', $this->object->getFragment());
    }

    public function testEmptyDsn(): void
    {
        $this->expectException(InvalidValueException::class);

        DsnValue::create('');
    }

    public function testInvalidDsn()
    {
        $this->expectException(InvalidValueException::class);

        DsnValue::create('this is not a DSN string');
    }

    public function testCachedDsn()
    {
        $object1 = DsnValue::create(self::DSN, true);
        $object2 = DsnValue::create(self::DSN, true);

        self::assertSame($object1, $object2);
    }
}

<?php

declare(strict_types=1);

namespace DavidGarcia\ValueObject\Primitive\StringAlternatives;

use DavidGarcia\ValueObject\Exception\InvalidValueException;
use DavidGarcia\ValueObject\Primitive\AbstractValue;
use InvalidArgumentException;
use Webmozart\Assert\Assert;

class DsnValue extends AbstractValue
{
    private string $value;
    private ?string $scheme;
    private ?string $user;
    private ?string $pass;
    private ?string $host;
    private ?int $port;
    private ?string $path;
    private array $query = [];
    private ?string $fragment;

    private function __construct(string $value, bool $cache)
    {
        $this->value = $value;

        // NULL or String

        $this->scheme = parse_url($this->value, PHP_URL_SCHEME);
        $this->user = parse_url($this->value, PHP_URL_USER);
        $this->pass = parse_url($this->value, PHP_URL_PASS);
        $this->host = parse_url($this->value, PHP_URL_HOST);
        $this->path = parse_url($this->value, PHP_URL_PATH);
        $this->fragment = parse_url($this->value, PHP_URL_FRAGMENT);

        // NULL or Int

        $this->port = parse_url($this->value, PHP_URL_PORT);

        // NULL or Array

        parse_str((string) parse_url($this->value, PHP_URL_QUERY), $this->query);

        // Validation

        try {
            Assert::stringNotEmpty($this->scheme, 'Unable to extract the DSN Scheme');
            Assert::stringNotEmpty($this->host, 'Unable to extract the DSN Host');
        } catch (InvalidArgumentException $exception) {
            throw new InvalidValueException($exception->getMessage(), $exception);
        }

        if ($cache) {
            self::cacheStore($this->value, $this);
        }
    }

    public static function create(string $value, bool $cache = false): DsnValue
    {
        $trimmed = trim($value);

        try {
            Assert::stringNotEmpty($trimmed, 'Data Source Name (DSN) value cannot be empty');
        } catch (InvalidArgumentException $exception) {
            throw new InvalidValueException($exception->getMessage(), $exception);
        }

        $object = $cache ? parent::cacheRetrieve($trimmed) : null;

        if (null === $object) {
            $object = new self($trimmed, $cache);
        }

        return $object;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getSanitizedValue(): string
    {
        return sprintf(
            '%s://%s%s%s%s%s',
            $this->scheme,
            $this->host,
            (!empty($this->port) ? sprintf(':%d', $this->port) : ''),
            $this->path,
            (!empty($this->query) ? sprintf('?%s', http_build_query($this->query)) : ''),
            (!empty($this->query) ? sprintf('#%s', $this->fragment) : '')
        );
    }

    /**
     * @return string
     */
    public function getScheme(): string
    {
        return $this->scheme;
    }

    /**
     * @return null|string
     */
    public function getUser(): ?string
    {
        return $this->user;
    }

    /**
     * @return null|string
     */
    public function getPass(): ?string
    {
        return $this->pass;
    }

    /**
     * @return null|string
     */
    public function getAuthorisationBasicToken(): ?string
    {
        if (null === $this->user && null === $this->pass) {
            return null;
        }

        return base64_encode(sprintf('%s:%s', $this->user, $this->pass));
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return null|int
     */
    public function getPort(): ?int
    {
        return $this->port;
    }

    /**
     * @return null|string
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * @return null|array
     */
    public function getQuery(): ?array
    {
        return !empty($this->query) ? $this->query : null;
    }

    /**
     * @return null|string
     */
    public function getFragment(): ?string
    {
        return $this->fragment;
    }
}

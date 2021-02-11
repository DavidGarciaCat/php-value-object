<?php

declare(strict_types=1);

namespace DavidGarcia\ValueObject\Primitive;

use DavidGarcia\ValueObject\Exception\InvalidValueException;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Result\InvalidEmail;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\RFCValidation;
use InvalidArgumentException;
use Webmozart\Assert\Assert;

class EmailValue extends StringValue
{
    /**
     * {@inheritdoc}
     */
    public static function create(string $value, bool $cache = false): StringValue
    {
        $trimmed = trim($value);

        try {
            Assert::stringNotEmpty($trimmed, 'Email value cannot be empty');
        } catch (InvalidArgumentException $exception) {
            throw new InvalidValueException($exception->getMessage(), $exception);
        }

        $validator = new EmailValidator();

        if (!$validator->isValid($trimmed, new RFCValidation())) {
            throw new InvalidValueException(self::emailValidatorError('RFC Validation has failed', $validator->getError()));
        }

        if (!$validator->isValid($trimmed, new DNSCheckValidation())) {
            throw new InvalidValueException(self::emailValidatorError('DNS Validation has failed', $validator->getError()));
        }

        return parent::create($trimmed, $cache);
    }

    /**
     * Creates a string message to expose the validator error.
     *
     * @param string       $message Generic error message
     * @param InvalidEmail $error   Error captured by the validator
     *
     * @return string The error message including the validator reason for failure
     */
    private static function emailValidatorError(string $message, InvalidEmail $error): string
    {
        return sprintf('%s: %s', $message, $error->description());
    }
}

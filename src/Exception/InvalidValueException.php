<?php

declare(strict_types=1);

namespace DavidGarcia\ValueObject\Exception;

use Exception;
use Throwable;

class InvalidValueException extends Exception
{
    public function __construct($message = "", Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}

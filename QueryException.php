<?php

namespace FpDbTest;

use Exception;

class QueryException extends Exception
{
    /**
     * @throws QueryException
     */
    public static function throwException(string $message, ...$options): QueryException
    {
        throw new self($message, ...$options);
    }
}
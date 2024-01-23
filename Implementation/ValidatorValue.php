<?php

namespace FpDbTest\Implementation;

use FpDbTest\QueryException;

trait ValidatorValue
{
    public function nullCheck(mixed $value): mixed
    {
        return $value ?? 'NULL';
    }

    public function validateValue(mixed $value)
    {
        if (is_null($value)) return 'NULL';

        if (is_numeric($value)) return $value;

        if (is_string($value)) return "'".$value."'";

        QueryException::throwException('Value type error');
    }

    public function escapeColumn(string $column): string
    {
        return "`" . $column ."`";
    }
}
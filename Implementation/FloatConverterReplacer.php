<?php

namespace FpDbTest\Implementation;

use FpDbTest\QueryException;
use FpDbTest\Specifier;

class FloatConverterReplacer implements SpecifierReplacerInterface
{
    use ValidatorValue;

    public function check(string $specifier): bool
    {
        return Specifier::FLOAT_SPECIFIER === $specifier;
    }

    public function replaceSpecifier(string $query, mixed $value): string
    {
        return preg_replace('/\?f/', $this->validateValue((float) $value), $query, 1);
    }
}
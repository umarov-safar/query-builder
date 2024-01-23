<?php

namespace FpDbTest\Implementation;

use FpDbTest\Specifier;

class IntegerConverterReplacer implements SpecifierReplacerInterface
{
    use ValidatorValue;

    public function check(string $specifier): bool
    {
        return Specifier::INTEGER_SPECIFIER === $specifier;
    }

    public function replaceSpecifier(string $query, mixed $value): string
    {
        return preg_replace('/\?d/', $this->nullCheck((int) $value), $query, 1);
    }
}
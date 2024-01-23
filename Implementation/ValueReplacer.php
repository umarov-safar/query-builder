<?php

namespace FpDbTest\Implementation;

use FpDbTest\Specifier;

class ValueReplacer implements SpecifierReplacerInterface
{
    use ValidatorValue;

    public function check(string $specifier): bool
    {
        return Specifier::VALUE_SPECIFIER === $specifier;
    }

    public function replaceSpecifier(string $query, mixed $value): string
    {
        return preg_replace('/\?/', $this->validateValue($value), $query, 1);
    }
}
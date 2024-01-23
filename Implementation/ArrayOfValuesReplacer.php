<?php

namespace FpDbTest\Implementation;

use FpDbTest\Specifier;

class ArrayOfValuesReplacer implements SpecifierReplacerInterface
{
    use ValidatorValue;

    public function check(string $specifier): bool
    {
        return Specifier::ARRAY_OF_VALUES_SPECIFIER === $specifier;
    }

    public function replaceSpecifier(string $query, mixed $value): string
    {
        $value = $this->makeValueReplaceable($value);

        return preg_replace('/\?a/', $value, $query, 1);
    }


    protected function makeValueReplaceable(mixed $value): string
    {
        if (!array_is_list($value)) {
            $value = array_map(function ($key, $value) {
                return sprintf('%s = %s', $this->escapeColumn($key), $this->validateValue($value));
            }, array_keys($value), array_values($value));
        }

        return implode(', ', $value);
    }


}
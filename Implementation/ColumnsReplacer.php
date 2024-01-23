<?php

namespace FpDbTest\Implementation;

use FpDbTest\Specifier;

class ColumnsReplacer implements SpecifierReplacerInterface
{
    use ValidatorValue;

    public function check(string $specifier): bool
    {
        return Specifier::COLUMNS_SPECIFIERS === $specifier;
    }

    public function replaceSpecifier(string $query, mixed $value): string
    {
        if (is_array($value)) {
            $values = array_map(fn($column) => $this->escapeColumn($column), $value);
            $value = implode(', ', $values);
        } else {
            $value = $this->escapeColumn($value);
        }

        return preg_replace('/\?#/', $value, $query, 1);
    }
}
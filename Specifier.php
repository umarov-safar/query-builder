<?php

namespace FpDbTest;

class Specifier
{
    const VALUE_SPECIFIER = '?';
    const INTEGER_SPECIFIER = '?d';
    const FLOAT_SPECIFIER = '?f';
    const ARRAY_OF_VALUES_SPECIFIER = '?a';
    const COLUMNS_SPECIFIERS = '?#';
    const BLOCK_SPECIFIER = '{}';

    public static function all(): array
    {
        return [
            self::VALUE_SPECIFIER,
            self::INTEGER_SPECIFIER,
            self::FLOAT_SPECIFIER,
            self::ARRAY_OF_VALUES_SPECIFIER,
            self::COLUMNS_SPECIFIERS,
            self::BLOCK_SPECIFIER
        ];
    }
}
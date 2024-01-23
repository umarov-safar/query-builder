<?php

namespace FpDbTest\Implementation;

interface SpecifierReplacerInterface
{
    public function check(string $specifier): bool;

    public function replaceSpecifier(string $query, mixed $value): string;
}
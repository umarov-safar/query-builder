<?php

namespace FpDbTest\Implementation;

use FpDbTest\DatabaseInterface;
use FpDbTest\Specifier;

class BlockConditionReplacer implements SpecifierReplacerInterface
{
    private string $skip;

    private DatabaseInterface $database;

    public function __construct(string $skip, ?DatabaseInterface $database)
    {
        $this->skip = $skip;
        $this->database = $database;
    }

    public function check(string $specifier): bool
    {
        return Specifier::BLOCK_SPECIFIER === preg_replace('/^\{.*}$/', '{}', $specifier);
    }

    public function replaceSpecifier(string $query, mixed $value): string
    {
        if ($value === $this->skip) {
            return preg_replace('/\{.*\}/', '', $query, 1);
        }

        $query = str_replace(['{', '}'], '', $query);
        return $this->database->buildQuery($query, [$value]);
    }
}
<?php

namespace FpDbTest;

use FpDbTest\Implementation\ArrayOfValuesReplacer;
use FpDbTest\Implementation\BlockConditionReplacer;
use FpDbTest\Implementation\ColumnsReplacer;
use FpDbTest\Implementation\FloatConverterReplacer;
use FpDbTest\Implementation\IntegerConverterReplacer;
use FpDbTest\Implementation\SpecifierReplacerInterface;
use FpDbTest\Implementation\ValueReplacer;
use mysqli;

class Database implements DatabaseInterface
{
    private mysqli $mysqli;

    /**
     * @var SpecifierReplacerInterface[] $specifierReplacers
     */
    private array $specifierReplacers;


    public function __construct(mysqli $mysqli)
    {
        $this->mysqli = $mysqli;

        $this->specifierReplacers = [
            new ValueReplacer(),
            new ArrayOfValuesReplacer(),
            new ColumnsReplacer(),
            new FloatConverterReplacer(),
            new IntegerConverterReplacer(),
            new BlockConditionReplacer($this->skip(), $this)
        ];

    }

    /**
     * @throws QueryException
     */
    public function buildQuery(string $query, array $args = []): string
    {
        $specifiers = $this->getSpecifiersFromQuery($query);

        // Check if there are specifiers in the query but no arguments provided, или наоборот.
        // If so, throw a QueryException.
        if (($specifiers && !$args) || (!$specifiers && $args)) {
            QueryException::throwException('Arguments error');
        }

        foreach ($specifiers as $key => $specifier) {
            foreach ($this->specifierReplacers as $specifierReplacer) {
                if ($specifierReplacer->check($specifier)) {
                    $query = $specifierReplacer->replaceSpecifier($query, $args[$key]);
                }
            }
        }

        return $query;
    }

    protected function getSpecifiersFromQuery(string $query): array|string
    {
        preg_match_all('/(\?#)|(\?a)|(\?d)|(\?f)|(\?)|(\{.*})/i', $query, $matches, PREG_PATTERN_ORDER);

        // array of full pattern matches
        return $matches[0];
    }

    public function skip(): string
    {
        return '__SKIP__';
    }


}

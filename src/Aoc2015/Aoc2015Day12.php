<?php

/*
https://adventofcode.com/2015/day/12
Part 1: What is the sum of all numbers in the document?
Part 2: Uh oh - the Accounting-Elves have realized that they double-counted everything red.
*/

declare(strict_types=1);

namespace TBali\Aoc2015;

use TBali\Aoc\SolutionBase;

class Aoc2015Day12 extends SolutionBase
{
    public const YEAR = 2015;
    public const DAY = 12;
    public const TITLE = 'JSAbacusFramework.io';
    public const SOLUTIONS = [111754, 65402];
    public const EXAMPLE_SOLUTIONS = [[0, 0], [0, 0]];

    /**
     * @param string[] $input
     *
     * @return array{string, string}
     */
    public function solve(array $input): array
    {
        $input = implode('', $input);
        // ---------- Part 1
        $a = json_decode($input, true) ?? []; // true: JSON objects will be returned as associative arrays
        $count = 0;
        // @phpstan-ignore-next-line77
        array_walk_recursive($a, function ($x) use (&$count) {
            if (is_numeric($x)) {
                $count += intval($x);
            }
        }, $count);
        $ans1 = $count;
        // ---------- Part 2
        $a = json_decode($input, false) ?? []; // JSON objects will be returned as objects.
        $ans2 = $this->sumNonRed($a);
        return [strval($ans1), strval($ans2)];
    }

    // --------------------------------------------------------------------
    private function sumNonRed(mixed $a): int
    {
        if (is_numeric($a)) {
            return intval($a);
        }
        if (is_object($a)) {
            $isOk = true;
            // @phpstan-ignore-next-line77
            foreach ($a as $item) {
                if ($item == 'red') {
                    $isOk = false;
                    break;
                }
            }
            if (!$isOk) {
                return 0;
            }
        }
        if (!is_array($a) and !is_object($a)) {
            return 0;
        }
        $sum = 0;
        // @phpstan-ignore-next-line77
        foreach ($a as $item) {
            $sum += $this->sumNonRed($item);
        }
        return $sum;
    }
}

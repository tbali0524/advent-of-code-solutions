<?php

declare(strict_types=1);

namespace TBali\Aoc2019;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2019 Day 4: Secure Container.
 *
 * Part 1: How many different passwords within the range given in your puzzle input meet these criteria?
 * Part 2: How many different passwords within the range given in your puzzle input meet all of the criteria?
 *
 * @see https://adventofcode.com/2019/day/4
 */
final class Aoc2019Day04 extends SolutionBase
{
    public const YEAR = 2019;
    public const DAY = 4;
    public const TITLE = 'Secure Container';
    public const SOLUTIONS = [1864, 1258];
    public const STRING_INPUT = '137683-596253';
    public const EXAMPLE_SOLUTIONS = [[1, 1]];
    public const EXAMPLE_STRING_INPUTS = ['111122-111122'];

    /**
     * Solve both parts of the puzzle for a given input, without IO.
     *
     * @param array<int, string> $input The lines of the input, without LF
     *
     * @return array<int, string> The answers for Part 1 and Part 2 (as strings)
     *
     * @phpstan-return array{string, string}
     */
    public function solve(array $input): array
    {
        /** @var array<int, int> */
        $data = array_map(intval(...), explode('-', $input[0]));
        // ---------- Part 1 + 2
        $ans1 = 0;
        $ans2 = 0;
        for ($i = $data[0]; $i <= $data[1]; ++$i) {
            $s = strval($i);
            $hasDecrease = false;
            $hasDouble = false;
            $hasTrueDouble = false;
            for ($j = 1; $j < strlen($s); ++$j) {
                if ($s[$j] < $s[$j - 1]) {
                    $hasDecrease = true;
                    break;
                }
                if ($s[$j] == $s[$j - 1]) {
                    $hasDouble = true;
                    if (
                        (($j == 1) or ($s[$j] != $s[$j - 2]))
                        and (($j == strlen($s) - 1) or ($s[$j] != $s[$j + 1]))
                    ) {
                        $hasTrueDouble = true;
                    }
                }
            }
            if ($hasDouble and !$hasDecrease) {
                ++$ans1;
                if ($hasTrueDouble) {
                    ++$ans2;
                }
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}

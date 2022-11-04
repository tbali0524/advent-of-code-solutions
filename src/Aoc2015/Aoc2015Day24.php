<?php

// @TODO

/*
https://adventofcode.com/2015/day/24
Part 1: What is the quantum entanglement of the first group of packages in the ideal configuration?
Part 2:
*/

declare(strict_types=1);

namespace TBali\Aoc2015;

use TBali\Aoc\SolutionBase;

final class Aoc2015Day24 extends SolutionBase
{
    public const YEAR = 2015;
    public const DAY = 24;
    public const TITLE = 'It Hangs in the Balance';
    public const SOLUTIONS = [0, 0];
    public const EXAMPLE_SOLUTIONS = [[99, 0], [0, 0]];

    /**
     * @param string[] $input
     *
     * @return array{string, string}
     */
    public function solve(array $input): array
    {
        /** @var int[] */
        $input = array_map('intval', $input);
        // ---------- Part 1
        $ans1 = 0;
        // ---------- Part 2
        $ans2 = 0;
        return [strval($ans1), strval($ans2)];
    }
}

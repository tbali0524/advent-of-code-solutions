<?php

/*
https://adventofcode.com/2022/day/
Part 1: [This is only an empty template file for new solutions]
Part 2:
*/

declare(strict_types=1);

namespace TBali\Aoc2022;

use TBali\Aoc\SolutionBase;

final class Aoc2022Day00 extends SolutionBase
{
    public const YEAR = 2022;
    public const DAY = 0;
    public const TITLE = '';
    public const SOLUTIONS = [0, 0];
    public const EXAMPLE_SOLUTIONS = [[0, 0], [0, 0]];

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

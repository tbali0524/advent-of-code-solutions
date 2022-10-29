<?php

/*
https://adventofcode.com/2021/day/1
Part 1: How many measurements are larger than the previous measurement?
Part 2: Consider sums of a three-measurement sliding window. How many sums are larger than the previous sum?
*/

declare(strict_types=1);

namespace TBali\Aoc2021;

use TBali\Aoc\SolutionBase;

class Aoc2021Day01 extends SolutionBase
{
    public const YEAR = 2021;
    public const DAY = 1;
    public const TITLE = 'Sonar Sweep';
    public const SOLUTIONS = [1477, 1523];
    public const EXAMPLE_SOLUTIONS = [[7, 5], [0, 0]];

    private const WINDOW = 3;

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
        for ($i = 1; $i < count($input); ++$i) {
            if ($input[$i] > $input[$i - 1]) {
                ++$ans1;
            }
        }
        // ---------- Part 2
        $ans2 = 0;
        for ($i = self::WINDOW; $i < count($input); ++$i) {
            if ($input[$i] > $input[$i - self::WINDOW]) {
                ++$ans2;
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}

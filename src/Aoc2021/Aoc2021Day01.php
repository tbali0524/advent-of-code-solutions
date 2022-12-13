<?php

declare(strict_types=1);

namespace TBali\Aoc2021;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2021 Day 1: Sonar Sweep.
 *
 * Part 1: How many measurements are larger than the previous measurement?
 * Part 2: Consider sums of a three-measurement sliding window. How many sums are larger than the previous sum?
 *
 * @see https://adventofcode.com/2021/day/1
 */
final class Aoc2021Day01 extends SolutionBase
{
    public const YEAR = 2021;
    public const DAY = 1;
    public const TITLE = 'Sonar Sweep';
    public const SOLUTIONS = [1477, 1523];
    public const EXAMPLE_SOLUTIONS = [[7, 5]];

    private const WINDOW = 3;

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

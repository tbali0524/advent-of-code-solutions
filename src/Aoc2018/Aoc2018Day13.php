<?php

declare(strict_types=1);

namespace TBali\Aoc2018;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2018 Day 13: Mine Cart Madness.
 *
 * Part 1: To help prevent crashes, you'd like to know the location of the first crash.
 * Part 2:
 *
 * @see https://adventofcode.com/2018/day/13
 *
 * @todo complete
 */
final class Aoc2018Day13 extends SolutionBase
{
    public const YEAR = 2018;
    public const DAY = 13;
    public const TITLE = 'Mine Cart Madness';
    public const SOLUTIONS = [0, 0];
    public const EXAMPLE_SOLUTIONS = [['7,3', 0]];

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
        // ---------- Part 1
        $ans1 = 0;
        // ---------- Part 2
        $ans2 = 0;
        return [strval($ans1), strval($ans2)];
    }
}

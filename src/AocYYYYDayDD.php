<?php

declare(strict_types=1);

namespace TBali\AocYYYY;

use TBali\Aoc\SolutionBase;

/**
 * AoC YYYY Day DD: CODE SKELETON FOR SOLUTION.
 *
 * @see https://adventofcode.com/YYYY/day/DD
 */
final class AocYYYYDayDD extends SolutionBase
{
    public const YEAR = 2025;
    public const DAY = 0;
    public const TITLE = '';
    public const SOLUTIONS = [0, 0];
    public const EXAMPLE_SOLUTIONS = [[0, 0]];

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
        // ---------- Parse input
        // ---------- Part 1
        $ans1 = 0;
        // ---------- Part 2
        $ans2 = 0;
        return [strval($ans1), strval($ans2)];
    }
}

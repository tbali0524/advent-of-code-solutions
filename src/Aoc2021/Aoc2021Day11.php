<?php

declare(strict_types=1);

namespace TBali\Aoc2021;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2021 Day 11: Dumbo Octopus.
 *
 * Part 1: How many total flashes are there after 100 steps?
 * Part 2:
 *
 * @see https://adventofcode.com/2021/day/11
 *
 * @todo complete
 *
 * @codeCoverageIgnore
 */
final class Aoc2021Day11 extends SolutionBase
{
    public const YEAR = 2021;
    public const DAY = 11;
    public const TITLE = 'Dumbo Octopus';
    public const SOLUTIONS = [0, 0];
    public const EXAMPLE_SOLUTIONS = [[1656, 0]];

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

<?php

declare(strict_types=1);

namespace TBali\Aoc2021;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2021 Day 14: Extended Polymerization.
 *
 * Part 1: What do you get if you take the quantity of the most common element
 *         and subtract the quantity of the least common element?
 * Part 2:
 *
 * @see https://adventofcode.com/2021/day/14
 *
 * @todo complete
 */
final class Aoc2021Day14 extends SolutionBase
{
    public const YEAR = 2021;
    public const DAY = 14;
    public const TITLE = 'Extended Polymerization';
    public const SOLUTIONS = [0, 0];
    public const EXAMPLE_SOLUTIONS = [[1588, 0]];

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

<?php

declare(strict_types=1);

namespace TBali\Aoc2019;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2019 Day 17: Set and Forget.
 *
 * Part 1: What is the sum of the alignment parameters for the scaffold intersections?
 * Part 2:
 *
 * @see https://adventofcode.com/2019/day/17
 *
 * @todo complete
 *
 * @codeCoverageIgnore
 */
final class Aoc2019Day17 extends SolutionBase
{
    public const YEAR = 2019;
    public const DAY = 17;
    public const TITLE = 'Set and Forget';
    public const SOLUTIONS = [0, 0];
    public const EXAMPLE_SOLUTIONS = [[76, 0]];

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

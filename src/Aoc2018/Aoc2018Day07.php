<?php

declare(strict_types=1);

namespace TBali\Aoc2018;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2018 Day 7: The Sum of Its Parts.
 *
 * Part 1: In what order should the steps in your instructions be completed?
 * Part 2:
 *
 * @see https://adventofcode.com/2018/day/7
 *
 * @todo complete
 */
final class Aoc2018Day07 extends SolutionBase
{
    public const YEAR = 2018;
    public const DAY = 7;
    public const TITLE = 'The Sum of Its Parts';
    public const SOLUTIONS = [0, 0];
    public const EXAMPLE_SOLUTIONS = [['CABDFE', 0]];

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

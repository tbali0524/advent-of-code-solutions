<?php

declare(strict_types=1);

namespace TBali\Aoc2019;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2019 Day 15: Oxygen System.
 *
 * Part 1: What is the fewest number of movement commands required to move the repair droid
 *         from its starting position to the location of the oxygen system?
 * Part 2:
 *
 * @see https://adventofcode.com/2019/day/15
 *
 * @todo complete
 *
 * @codeCoverageIgnore
 */
final class Aoc2019Day15 extends SolutionBase
{
    public const YEAR = 2019;
    public const DAY = 15;
    public const TITLE = 'Oxygen System';
    public const SOLUTIONS = [0, 0];
    public const EXAMPLE_SOLUTIONS = [[2, 0]];

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

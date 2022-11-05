<?php

declare(strict_types=1);

namespace TBali\Aoc2015;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2015 Day 24: It Hangs in the Balance.
 *
 * Part 1: What is the quantum entanglement of the first group of packages in the ideal configuration?
 * Part 2:
 *
 * @see https://adventofcode.com/2015/day/24
 *
 * @todo Part 1, 2
 */
final class Aoc2015Day24 extends SolutionBase
{
    public const YEAR = 2015;
    public const DAY = 24;
    public const TITLE = 'It Hangs in the Balance';
    public const SOLUTIONS = [0, 0];
    public const EXAMPLE_SOLUTIONS = [[99, 0], [0, 0]];

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
        // ---------- Part 2
        $ans2 = 0;
        return [strval($ans1), strval($ans2)];
    }
}

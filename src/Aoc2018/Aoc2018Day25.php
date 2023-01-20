<?php

declare(strict_types=1);

namespace TBali\Aoc2018;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2018 Day 25: Four-Dimensional Adventure.
 *
 * Part 1: How many constellations are formed by the fixed points in spacetime?
 * Part 2: N/A
 *
 * @see https://adventofcode.com/2018/day/25
 *
 * @todo complete
 */
final class Aoc2018Day25 extends SolutionBase
{
    public const YEAR = 2018;
    public const DAY = 25;
    public const TITLE = 'Four-Dimensional Adventure';
    public const SOLUTIONS = [0, 0];
    public const EXAMPLE_SOLUTIONS = [[2, 0], [4, 0], [3, 0], [8, 0]];

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
        return [strval($ans1), '0'];
    }
}

<?php

declare(strict_types=1);

namespace TBali\Aoc2018;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2018 Day 6: Chronal Coordinates.
 *
 * Part 1: What is the size of the largest area that isn't infinite?
 * Part 2:
 *
 * @see https://adventofcode.com/2018/day/6
 *
 * @todo complete
 */
final class Aoc2018Day06 extends SolutionBase
{
    public const YEAR = 2018;
    public const DAY = 6;
    public const TITLE = 'Chronal Coordinates';
    public const SOLUTIONS = [0, 0];
    public const EXAMPLE_SOLUTIONS = [[17, 0]];

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
        $data = array_map(intval(...), $input);
        // ---------- Part 1
        $ans1 = 0;
        // ---------- Part 2
        $ans2 = 0;
        return [strval($ans1), strval($ans2)];
    }
}
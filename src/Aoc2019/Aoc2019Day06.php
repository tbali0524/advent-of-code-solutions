<?php

declare(strict_types=1);

namespace TBali\Aoc2019;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2019 Day 6: Universal Orbit Map.
 *
 * Part 1: What is the total number of direct and indirect orbits in your map data?
 * Part 2:
 *
 * @see https://adventofcode.com/2019/day/6
 *
 * @todo complete
 *
 * @codeCoverageIgnore
 */
final class Aoc2019Day06 extends SolutionBase
{
    public const YEAR = 2019;
    public const DAY = 6;
    public const TITLE = 'Universal Orbit Map';
    public const SOLUTIONS = [0, 0];
    public const EXAMPLE_SOLUTIONS = [[42, 0]];

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

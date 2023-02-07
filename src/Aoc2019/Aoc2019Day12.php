<?php

declare(strict_types=1);

namespace TBali\Aoc2019;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2019 Day 12: The N-Body Problem.
 *
 * Part 1: What is the total energy in the system after simulating the moons given in your scan for 1000 steps?
 * Part 2:
 *
 * @see https://adventofcode.com/2019/day/12
 *
 * @todo complete
 *
 * @codeCoverageIgnore
 */
final class Aoc2019Day12 extends SolutionBase
{
    public const YEAR = 2019;
    public const DAY = 12;
    public const TITLE = 'The N-Body Problem';
    public const SOLUTIONS = [0, 0];
    public const EXAMPLE_SOLUTIONS = [[179, 0], [1940, 0]];

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

<?php

declare(strict_types=1);

namespace TBali\Aoc2019;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2019 Day 19: Tractor Beam.
 *
 * Part 1: How many points are affected by the tractor beam in the 50x50 area closest to the emitter?
 * Part 2:
 *
 * @see https://adventofcode.com/2019/day/19
 *
 * @todo complete
 *
 * @codeCoverageIgnore
 */
final class Aoc2019Day19 extends SolutionBase
{
    public const YEAR = 2019;
    public const DAY = 19;
    public const TITLE = 'Tractor Beam';
    public const SOLUTIONS = [0, 0];
    public const EXAMPLE_SOLUTIONS = [[27, 0]];

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

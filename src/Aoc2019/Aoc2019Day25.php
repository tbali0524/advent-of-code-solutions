<?php

declare(strict_types=1);

namespace TBali\Aoc2019;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2019 Day 25: Cryostasis.
 *
 * Part 1: Look around the ship and see if you can find the password for the main airlock.
 * Part 2: N/A
 *
 * @see https://adventofcode.com/2019/day/25
 *
 * @todo complete
 *
 * @codeCoverageIgnore
 */
final class Aoc2019Day25 extends SolutionBase
{
    public const YEAR = 2019;
    public const DAY = 25;
    public const TITLE = 'Cryostasis';
    public const SOLUTIONS = [0, 0];
    public const EXAMPLE_SOLUTIONS = [[0, 0]];

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

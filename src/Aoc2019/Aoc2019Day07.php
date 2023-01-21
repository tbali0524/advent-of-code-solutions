<?php

declare(strict_types=1);

namespace TBali\Aoc2019;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2019 Day 7: Amplification Circuit.
 *
 * Part 1: What is the highest signal that can be sent to the thrusters?
 * Part 2:
 *
 * @see https://adventofcode.com/2019/day/7
 *
 * @todo complete
 */
final class Aoc2019Day07 extends SolutionBase
{
    public const YEAR = 2019;
    public const DAY = 7;
    public const TITLE = 'Amplification Circuit';
    public const SOLUTIONS = [0, 0];
    public const EXAMPLE_SOLUTIONS = [[43210, 0], [54321, 0], [65210, 0]];

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

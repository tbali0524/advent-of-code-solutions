<?php

declare(strict_types=1);

namespace TBali\Aoc2018;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2018 Day 8: Memory Maneuver.
 *
 * Part 1: What is the sum of all metadata entries?
 * Part 2:
 *
 * @see https://adventofcode.com/2018/day/8
 *
 * @todo complete
 */
final class Aoc2018Day08 extends SolutionBase
{
    public const YEAR = 2018;
    public const DAY = 8;
    public const TITLE = 'Memory Maneuver';
    public const SOLUTIONS = [0, 0];
    public const EXAMPLE_SOLUTIONS = [[138, 0]];

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
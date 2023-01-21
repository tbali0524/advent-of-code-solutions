<?php

declare(strict_types=1);

namespace TBali\Aoc2021;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2021 Day 2: Dive!.
 *
 * Part 1: What is the checksum for your list of box IDs?
 * Part 2:
 *
 * @see https://adventofcode.com/2021/day/2
 *
 * @todo complete
 */
final class Aoc2021Day02 extends SolutionBase
{
    public const YEAR = 2021;
    public const DAY = 2;
    public const TITLE = 'Dive!';
    public const SOLUTIONS = [0, 0];
    public const EXAMPLE_SOLUTIONS = [[150, 0]];

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

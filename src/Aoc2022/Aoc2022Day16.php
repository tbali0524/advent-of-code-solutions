<?php

declare(strict_types=1);

namespace TBali\Aoc2022;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2022 Day 16: Proboscidea Volcanium.
 *
 * Part 1: Work out the steps to release the most pressure in 30 minutes. What is the most pressure you can release?
 * Part 2:
 *
 * @see https://adventofcode.com/2022/day/16
 */
final class Aoc2022Day16 extends SolutionBase
{
    public const YEAR = 2022;
    public const DAY = 16;
    public const TITLE = 'Proboscidea Volcanium';
    public const SOLUTIONS = [0, 0];
    public const EXAMPLE_SOLUTIONS = [[1651, 0]];

    // private const MAX_TIME = 30;

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

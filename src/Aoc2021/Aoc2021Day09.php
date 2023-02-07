<?php

declare(strict_types=1);

namespace TBali\Aoc2021;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2021 Day 9: Smoke Basin.
 *
 * Part 1: What is the sum of the risk levels of all low points on your heightmap?
 * Part 2:
 *
 * @see https://adventofcode.com/2021/day/9
 *
 * @todo complete
 *
 * @codeCoverageIgnore
 */
final class Aoc2021Day09 extends SolutionBase
{
    public const YEAR = 2021;
    public const DAY = 9;
    public const TITLE = 'Smoke Basin';
    public const SOLUTIONS = [0, 0];
    public const EXAMPLE_SOLUTIONS = [[15, 0]];

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

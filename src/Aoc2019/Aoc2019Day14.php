<?php

declare(strict_types=1);

namespace TBali\Aoc2019;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2019 Day 14: Space Stoichiometry.
 *
 * Part 1: What is the minimum amount of ORE required to produce exactly 1 FUEL?
 * Part 2:
 *
 * @see https://adventofcode.com/2019/day/14
 *
 * @todo complete
 */
final class Aoc2019Day14 extends SolutionBase
{
    public const YEAR = 2019;
    public const DAY = 14;
    public const TITLE = 'Space Stoichiometry';
    public const SOLUTIONS = [0, 0];
    public const EXAMPLE_SOLUTIONS = [[31, 0], [165, 0], [13312, 0], [180697, 0], [2210736, 0]];

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

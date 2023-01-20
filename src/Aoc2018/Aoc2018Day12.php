<?php

declare(strict_types=1);

namespace TBali\Aoc2018;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2018 Day 12: Subterranean Sustainability.
 *
 * Part 1: After 20 generations, what is the sum of the numbers of all pots which contain a plant?
 * Part 2:
 *
 * @see https://adventofcode.com/2018/day/12
 *
 * @todo complete
 */
final class Aoc2018Day12 extends SolutionBase
{
    public const YEAR = 2018;
    public const DAY = 12;
    public const TITLE = 'Subterranean Sustainability';
    public const SOLUTIONS = [0, 0];
    public const EXAMPLE_SOLUTIONS = [[325, 0]];

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

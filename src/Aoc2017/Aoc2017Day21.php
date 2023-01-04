<?php

declare(strict_types=1);

namespace TBali\Aoc2017;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2017 Day 21: Fractal Art.
 *
 * Part 1: How many pixels stay on after 5 iterations?
 * Part 2:
 *
 * @see https://adventofcode.com/2017/day/21
 *
 * @todo complete
 */
final class Aoc2017Day21 extends SolutionBase
{
    public const YEAR = 2017;
    public const DAY = 21;
    public const TITLE = 'Fractal Art';
    public const SOLUTIONS = [0, 0];
    public const EXAMPLE_SOLUTIONS = [[12, 0]];

    private const MAX_TURNS_PART1 = 5;

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

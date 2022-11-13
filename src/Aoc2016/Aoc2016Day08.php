<?php

declare(strict_types=1);

namespace TBali\Aoc2016;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2016 Day 8: Two-Factor Authentication.
 *
 * Part 1: After you swipe your card, if the screen did work, how many pixels should be lit?
 * Part 2:
 *
 * @see https://adventofcode.com/2016/day/8
 */
final class Aoc2016Day08 extends SolutionBase
{
    public const YEAR = 2016;
    public const DAY = 8;
    public const TITLE = 'Two-Factor Authentication';
    public const SOLUTIONS = [0, 0];
    public const EXAMPLE_SOLUTIONS = [[6, 0], [0, 0]];

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

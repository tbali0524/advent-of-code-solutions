<?php

declare(strict_types=1);

namespace TBali\Aoc2018;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2018 Day 11: Chronal Charge.
 *
 * Part 1: What is the X,Y coordinate of the top-left fuel cell of the 3x3 square with the largest total power?
 * Part 2:
 *
 * @see https://adventofcode.com/2018/day/11
 *
 * @todo complete
 */
final class Aoc2018Day11 extends SolutionBase
{
    public const YEAR = 2018;
    public const DAY = 11;
    public const TITLE = 'Chronal Charge';
    public const SOLUTIONS = [0, 0];
    public const STRING_INPUT = '2866';
    public const EXAMPLE_SOLUTIONS = [['21,61', 0]];
    public const EXAMPLE_STRING_INPUTS = ['42'];

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

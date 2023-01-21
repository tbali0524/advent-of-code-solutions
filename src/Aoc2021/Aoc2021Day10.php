<?php

declare(strict_types=1);

namespace TBali\Aoc2021;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2021 Day 10: Syntax Scoring.
 *
 * Part 1: What is the total syntax error score for those errors?
 * Part 2:
 *
 * @see https://adventofcode.com/2021/day/10
 *
 * @todo complete
 */
final class Aoc2021Day10 extends SolutionBase
{
    public const YEAR = 2021;
    public const DAY = 10;
    public const TITLE = 'Syntax Scoring';
    public const SOLUTIONS = [0, 0];
    public const EXAMPLE_SOLUTIONS = [[26397, 0]];

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

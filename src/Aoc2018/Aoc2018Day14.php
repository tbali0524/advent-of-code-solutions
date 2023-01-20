<?php

declare(strict_types=1);

namespace TBali\Aoc2018;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2018 Day 14: Chocolate Charts.
 *
 * Part 1: What are the scores of the ten recipes immediately after the number of recipes in your puzzle input?
 * Part 2:
 *
 * @see https://adventofcode.com/2018/day/14
 *
 * @todo complete
 */
final class Aoc2018Day14 extends SolutionBase
{
    public const YEAR = 2018;
    public const DAY = 14;
    public const TITLE = 'Chocolate Charts';
    public const SOLUTIONS = [0, 0];
    public const STRING_INPUT = '190221';
    public const EXAMPLE_SOLUTIONS = [['5158916779', 0], ['0124515891', 0], ['9251071085', 0], ['5941429882', 0]];
    public const EXAMPLE_STRING_INPUTS = ['9', '5', '18', '2018'];

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

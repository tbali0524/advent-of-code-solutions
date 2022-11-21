<?php

declare(strict_types=1);

namespace TBali\Aoc2016;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2016 Day 19: An Elephant Named Joseph.
 *
 * Part 1: With the number of Elves given in your puzzle input, which Elf gets all the presents?
 * Part 2:
 *
 * @todo solve
 *
 * @see https://adventofcode.com/2016/day/19
 */
final class Aoc2016Day19 extends SolutionBase
{
    public const YEAR = 2016;
    public const DAY = 19;
    public const TITLE = 'An Elephant Named Joseph';
    public const SOLUTIONS = [0, 0];
    public const STRING_INPUT = '3017957';
    public const EXAMPLE_SOLUTIONS = [[0, 0], [0, 0]]; // Part 1: 3
    public const EXAMPLE_STRING_INPUTS = ['5', ''];

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
        $n = intval($input[0]);
        // ---------- Part 1
        $ans1 = 0;
        // ---------- Part 2
        $ans2 = 0;
        return [strval($ans1), strval($ans2)];
    }
}

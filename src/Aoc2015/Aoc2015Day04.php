<?php

declare(strict_types=1);

namespace TBali\Aoc2015;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2015 Day 4: The Ideal Stocking Stuffer.
 *
 * Part 1: You must find Santa the lowest positive number that produces such a hash.
 * Part 2: Now find one that starts with six zeroes.
 *
 * @see https://adventofcode.com/2015/day/4
 *
 * @codeCoverageIgnore
 */
final class Aoc2015Day04 extends SolutionBase
{
    public const YEAR = 2015;
    public const DAY = 4;
    public const TITLE = 'The Ideal Stocking Stuffer';
    public const SOLUTIONS = [254575, 1038736];
    public const STRING_INPUT = 'bgvyzdsv';
    public const EXAMPLE_SOLUTIONS = [[609043, 0], [1048970, 0]];
    public const EXAMPLE_STRING_INPUTS = ['abcdef', 'pqrstuv'];

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
        $line = $input[0];
        // ---------- Part 1
        $ans1 = 1;
        while (substr(md5($line . strval($ans1)), 0, 5) !== '00000') {
            ++$ans1;
        }
        // ---------- Part 2
        $ans2 = 1;
        while (substr(md5($line . strval($ans2)), 0, 6) !== '000000') {
            ++$ans2;
        }
        return [strval($ans1), strval($ans2)];
    }
}

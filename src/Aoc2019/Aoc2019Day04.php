<?php

declare(strict_types=1);

namespace TBali\Aoc2019;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2019 Day 4: Secure Container.
 *
 * Part 1: How many different passwords within the range given in your puzzle input meet these criteria?
 * Part 2:
 *
 * @see https://adventofcode.com/2019/day/4
 *
 * @todo complete
 */
final class Aoc2019Day04 extends SolutionBase
{
    public const YEAR = 2019;
    public const DAY = 4;
    public const TITLE = 'Secure Container';
    public const SOLUTIONS = [0, 0];
    public const STRING_INPUT = '137683-596253';
    public const EXAMPLE_SOLUTIONS = [[1, 0]];
    public const EXAMPLE_STRING_INPUTS = ['111111-111111'];

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
        /** @var array<int, int> */
        $data = array_map(intval(...), $input);
        // ---------- Part 1
        $ans1 = 0;
        // ---------- Part 2
        $ans2 = 0;
        return [strval($ans1), strval($ans2)];
    }
}

<?php

declare(strict_types=1);

namespace TBali\Aoc2018;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2018 Day 4: Repose Record.
 *
 * Part 1: What is the ID of the guard you chose multiplied by the minute you chose?
 * Part 2:
 *
 * @see https://adventofcode.com/2018/day/4
 *
 * @todo complete
 */
final class Aoc2018Day04 extends SolutionBase
{
    public const YEAR = 2018;
    public const DAY = 4;
    public const TITLE = 'Repose Record';
    public const SOLUTIONS = [0, 0];
    public const EXAMPLE_SOLUTIONS = [[240, 0]];

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

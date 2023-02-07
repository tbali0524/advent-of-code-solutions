<?php

declare(strict_types=1);

namespace TBali\Aoc2021;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2021 Day 25: Sea Cucumber.
 *
 * Part 1: What is the first step on which no sea cucumbers move?
 * Part 2: N/A
 *
 * @see https://adventofcode.com/2021/day/25
 *
 * @todo complete
 *
 * @codeCoverageIgnore
 */
final class Aoc2021Day25 extends SolutionBase
{
    public const YEAR = 2021;
    public const DAY = 25;
    public const TITLE = 'Sea Cucumber';
    public const SOLUTIONS = [0, 0];
    public const EXAMPLE_SOLUTIONS = [[58, 0]];

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
        return [strval($ans1), '0'];
    }
}

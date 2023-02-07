<?php

declare(strict_types=1);

namespace TBali\Aoc2019;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2019 Day 5: Sunny with a Chance of Asteroids.
 *
 * Part 1: After providing 1 to the only input instruction and passing all the tests,
 *         what diagnostic code does the program produce?
 * Part 2:
 *
 * @see https://adventofcode.com/2019/day/5
 *
 * @todo complete
 *
 * @codeCoverageIgnore
 */
final class Aoc2019Day05 extends SolutionBase
{
    public const YEAR = 2019;
    public const DAY = 5;
    public const TITLE = 'Sunny with a Chance of Asteroids';
    public const SOLUTIONS = [0, 0];
    public const EXAMPLE_SOLUTIONS = [[0, 0]];

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

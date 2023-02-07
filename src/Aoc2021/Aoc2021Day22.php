<?php

declare(strict_types=1);

namespace TBali\Aoc2021;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2021 Day 22: Reactor Reboot.
 *
 * Part 1: Afterward, considering only cubes in the region x=-50..50,y=-50..50,z=-50..50, how many cubes are on?
 * Part 2:
 *
 * @see https://adventofcode.com/2021/day/22
 *
 * @todo complete
 *
 * @codeCoverageIgnore
 */
final class Aoc2021Day22 extends SolutionBase
{
    public const YEAR = 2021;
    public const DAY = 22;
    public const TITLE = 'Reactor Reboot';
    public const SOLUTIONS = [0, 0];
    public const EXAMPLE_SOLUTIONS = [[39, 0], [590784, 0]];

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

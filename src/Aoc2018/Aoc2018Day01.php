<?php

declare(strict_types=1);

namespace TBali\Aoc2018;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2018 Day 1: Chronal Calibration.
 *
 * Part 1: What is the resulting frequency after all of the changes in frequency have been applied?
 * Part 2: What is the first frequency your device reaches twice?
 *
 * @see https://adventofcode.com/2018/day/1
 */
final class Aoc2018Day01 extends SolutionBase
{
    public const YEAR = 2018;
    public const DAY = 1;
    public const TITLE = 'Chronal Calibration';
    public const SOLUTIONS = [590, 83445];
    public const EXAMPLE_SOLUTIONS = [[3, 2]];

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
        $input = array_map('intval', $input);
        // ---------- Part 1
        $ans1 = array_sum($input);
        // ---------- Part 2
        $ans2 = 0;
        $memo = [];
        $freq = 0;
        while (true) {
            foreach ($input as $delta) {
                $freq += $delta;
                if (isset($memo[$freq])) {
                    $ans2 = $freq;
                    break 2;
                }
                $memo[$freq] = true;
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}

<?php

declare(strict_types=1);

namespace TBali\Aoc2022;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2022 Day 4: Camp Cleanup.
 *
 * Part 1: In how many assignment pairs does one range fully contain the other?
 * Part 2: In how many assignment pairs do the ranges overlap?
 *
 * @see https://adventofcode.com/2022/day/4
 */
final class Aoc2022Day04 extends SolutionBase
{
    public const YEAR = 2022;
    public const DAY = 4;
    public const TITLE = 'Camp Cleanup';
    public const SOLUTIONS = [530, 903];
    public const EXAMPLE_SOLUTIONS = [[2, 4]];

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
        // ---------- Parse input
        $data = array_map(static function (string $line): array {
            $a = explode(',', $line);
            if (count($a) != 2) {
                throw new \Exception('Invalid input');
            }
            $left = explode('-', $a[0]);
            $right = explode('-', $a[1]);
            if ((count($left) != 2) or (count($right) != 2)) {
                throw new \Exception('Invalid input');
            }
            return [intval($left[0]), intval($left[1]), intval($right[0]), intval($right[1])];
        }, $input);
        // ---------- Part 1
        $ans1 = count(array_filter(
            $data,
            static fn (array $a): bool => ($a[0] <= $a[2] && $a[3] <= $a[1]) || ($a[2] <= $a[0] && $a[1] <= $a[3])
        ));
        // ---------- Part 2
        $ans2 = count(array_filter(
            $data,
            static fn (array $a): bool => !(($a[1] < $a[2]) || ($a[3] < $a[0]))
        ));
        return [strval($ans1), strval($ans2)];
    }
}

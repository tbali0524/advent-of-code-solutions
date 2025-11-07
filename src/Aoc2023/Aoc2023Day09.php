<?php

declare(strict_types=1);

namespace TBali\Aoc2023;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2023 Day 9: Mirage Maintenance.
 *
 * Part 1: What is the sum of these extrapolated values?
 * Part 2: ...extrapolating the previous value for each history. What is the sum of these extrapolated values?
 *
 * Topics: recursion
 *
 * @see https://adventofcode.com/2023/day/9
 */
final class Aoc2023Day09 extends SolutionBase
{
    public const YEAR = 2023;
    public const DAY = 9;
    public const TITLE = 'Mirage Maintenance';
    public const SOLUTIONS = [1861775706, 1082];
    public const EXAMPLE_SOLUTIONS = [[114, 2]];

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
        /** @var array<int, array<int, int>> */
        $data = array_map(
            static fn (string $s): array => array_map(intval(...), explode(' ', $s)),
            $input,
        );
        // ---------- Part 1
        $ans1 = array_sum(array_map(self::extrapolateNext(...), $data));
        // ---------- Part 2
        $ans2 = array_sum(array_map(self::extrapolatePrev(...), $data));
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param array<int, int> $a
     */
    public static function extrapolateNext(array $a): int
    {
        if (count(array_filter($a, static fn (int $x): bool => $x != 0)) == 0) {
            return 0;
        }
        $diff = [];
        for ($i = 1; $i < count($a); ++$i) {
            $diff[] = $a[$i] - $a[$i - 1];
        }
        return $a[count($a) - 1] + self::extrapolateNext($diff);
    }

    /**
     * @param array<int, int> $a
     */
    public static function extrapolatePrev(array $a): int
    {
        if (count(array_filter($a, static fn (int $x): bool => $x != 0)) == 0) {
            return 0;
        }
        $diff = [];
        for ($i = 1; $i < count($a); ++$i) {
            $diff[] = $a[$i] - $a[$i - 1];
        }
        return $a[0] - self::extrapolatePrev($diff);
    }
}

<?php

declare(strict_types=1);

namespace TBali\Aoc2025;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2025 Day 1: Secret Entrance.
 *
 * @see https://adventofcode.com/2025/day/1
 */
final class Aoc2025Day01 extends SolutionBase
{
    public const YEAR = 2025;
    public const DAY = 1;
    public const TITLE = 'Secret Entrance';
    public const SOLUTIONS = [1092, 6616];
    public const EXAMPLE_SOLUTIONS = [[3, 6]];

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
        $rotations = [];
        foreach ($input as $row) {
            $sign = match ($row[0] ?? ' ') {
                'L' => -1,
                'R' => 1,
                default => throw new \Exception('Invalid input'),
            };
            $rotations[] = $sign * intval(substr($row, 1));
        }
        // ---------- Part 1 + 2
        $ans1 = 0;
        $ans2 = 0;
        $dial = 50;
        foreach ($rotations as $delta) {
            $ans2 += intdiv(abs($dial + $delta), 100);
            if ($dial != 0 && $dial + $delta <= 0) {
                ++$ans2;
            }
            $dial = (($dial + $delta) % 100 + 100) % 100;
            if ($dial == 0) {
                ++$ans1;
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}

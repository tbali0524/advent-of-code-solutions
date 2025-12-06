<?php

declare(strict_types=1);

namespace TBali\Aoc2025;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2025 Day 4: Printing Department.
 *
 * @see https://adventofcode.com/2025/day/4
 */
final class Aoc2025Day04 extends SolutionBase
{
    public const YEAR = 2025;
    public const DAY = 4;
    public const TITLE = 'Printing Department';
    public const SOLUTIONS = [1416, 9086];
    public const EXAMPLE_SOLUTIONS = [[13, 43]];

    public const string FILLED = '@';

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
        $max_y = count($input);
        $max_x = strlen($input[0] ?? '');
        // ---------- Part 1
        $ans1 = 0;
        for ($y = 0; $y < $max_y; ++$y) {
            for ($x = 0; $x < $max_x; ++$x) {
                if ($this->canRemove($input, $x, $y)) {
                    ++$ans1;
                }
            }
        }
        // ---------- Part 2
        $ans2 = 0;
        $grid = $input;
        $prev = 1;
        while ($ans2 != $prev) {
            $prev = $ans2;
            for ($y = 0; $y < $max_y; ++$y) {
                for ($x = 0; $x < $max_x; ++$x) {
                    if ($this->canRemove($grid, $x, $y)) {
                        ++$ans2;
                        $grid[$y][$x] = 'x';
                    }
                }
            }
        }
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param array<int, string> $input The lines of the input, without LF
     */
    public function canRemove(array $input, int $x, int $y): bool
    {
        if ($input[$y][$x] != self::FILLED) {
            return false;
        }
        $max_y = count($input);
        $max_x = strlen($input[0] ?? '');
        $count = 0;
        for ($dy = -1; $dy <= 1; ++$dy) {
            $ny = $y + $dy;
            if ($ny < 0 || $ny >= $max_y) {
                continue;
            }
            for ($dx = -1; $dx <= 1; ++$dx) {
                $nx = $x + $dx;
                if ($nx < 0 || $nx >= $max_x) {
                    continue;
                }
                if ($dy == 0 && $dx == 0) {
                    continue;
                }
                if ($input[$ny][$nx] == self::FILLED) {
                    ++$count;
                }
            }
        }
        return $count < 4;
    }
}

<?php

declare(strict_types=1);

namespace TBali\Aoc2025;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2025 Day 7: Laboratories.
 *
 * @see https://adventofcode.com/2025/day/7
 */
final class Aoc2025Day07 extends SolutionBase
{
    public const YEAR = 2025;
    public const DAY = 7;
    public const TITLE = 'Laboratories';
    public const SOLUTIONS = [1573, 15093663987272];
    public const EXAMPLE_SOLUTIONS = [[21, 40]];

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
        $start = strpos($input[0], 'S');
        if ($start === false) {
            throw new \Exception('Invalid input');
        }
        // ---------- Part 1
        $ans1 = 0;
        $tachyons = [$start];
        for ($y = 1; $y < count($input); ++$y) {
            $next_tachyons = [];
            foreach ($tachyons as $x) {
                $prev_x = $next_tachyons[count($next_tachyons) - 1] ?? ~PHP_INT_MAX;
                if ($input[$y][$x] == '.') {
                    if ($x != $prev_x) {
                        $next_tachyons[] = $x;
                    }
                    continue;
                }
                if ($input[$y][$x] != '^') {
                    throw new \Exception('Invalid input');
                }
                if ($x - 1 != $prev_x) {
                    $next_tachyons[] = $x - 1;
                }
                $next_tachyons[] = $x + 1;
                ++$ans1;
            }
            $tachyons = $next_tachyons;
        }
        // ---------- Part 2
        $ans2 = 0;
        $tachyons = [[$start, 1]];
        for ($y = 1; $y < count($input); ++$y) {
            $next_tachyons = [];
            foreach ($tachyons as [$x, $t]) {
                [$prev_x, $prev_t] = $next_tachyons[count($next_tachyons) - 1] ?? [~PHP_INT_MAX, 0];
                if ($input[$y][$x] == '.') {
                    if ($x != $prev_x) {
                        $next_tachyons[] = [$x, $t];
                        continue;
                    }
                    array_pop($next_tachyons);
                    $next_tachyons[] = [$x, $t + $prev_t];
                    continue;
                }
                if ($x - 1 != $prev_x) {
                    $next_tachyons[] = [$x - 1, $t];
                    $next_tachyons[] = [$x + 1, $t];
                    continue;
                }
                array_pop($next_tachyons);
                $next_tachyons[] = [$x - 1, $t + $prev_t];
                $next_tachyons[] = [$x + 1, $t];
            }
            $tachyons = $next_tachyons;
        }
        foreach ($tachyons as [$x, $t]) {
            $ans2 += $t;
        }
        return [strval($ans1), strval($ans2)];
    }
}

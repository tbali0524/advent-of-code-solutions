<?php

declare(strict_types=1);

namespace TBali\Aoc2022;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2022 Day 9: Rope Bridge.
 *
 * Part 1: How many positions does the tail of the rope visit at least once?
 * Part 2: Simulate your complete series of motions on a larger rope with ten knots.
 *         How many positions does the tail of the rope visit at least once?
 *
 * Topics: walk simulation
 *
 * @see https://adventofcode.com/2022/day/9
 */
final class Aoc2022Day09 extends SolutionBase
{
    public const YEAR = 2022;
    public const DAY = 9;
    public const TITLE = 'Rope Bridge';
    public const SOLUTIONS = [6090, 2566];
    public const EXAMPLE_SOLUTIONS = [[13, 1], [0, 36]];
    // large input #1 takes ~2 mins, so skipped
    // public const LARGE_SOLUTIONS = [[16877673, 14108518]];

    private const LEN = 10;

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
        $tx = 0;
        $ty = 0;
        $hx = 0;
        $hy = 0;
        $visited = [$tx . ' ' . $ty => true];
        foreach ($input as $line) {
            $dir = $line[0] ?? '';
            $count = intval(substr($line, 2));
            for ($i = 0; $i < $count; ++$i) {
                [$dx, $dy] = ['R' => [1, 0], 'D' => [0, 1], 'L' => [-1, 0], 'U' => [0, -1]][$dir] ?? [0, 0];
                $hx += $dx;
                $hy += $dy;
                if ((abs($hx - $tx) <= 1) and (abs($hy - $ty) <= 1)) {
                    continue;
                }
                $tdx = min(1, max(-1, $hx - $tx));
                $tdy = min(1, max(-1, $hy - $ty));
                $tx += $tdx;
                $ty += $tdy;
                $visited[$tx . ' ' . $ty] = true;
            }
        }
        $ans1 = count($visited);
        // ---------- Part 2
        $x = array_fill(0, self::LEN, 0);
        $y = array_fill(0, self::LEN, 0);
        $visited = [$x[self::LEN - 1] . ' ' . $y[self::LEN - 1] => true];
        foreach ($input as $line) {
            $dir = $line[0] ?? '';
            $count = intval(substr($line, 2));
            for ($i = 0; $i < $count; ++$i) {
                [$dx, $dy] = ['R' => [1, 0], 'D' => [0, 1], 'L' => [-1, 0], 'U' => [0, -1]][$dir] ?? [0, 0];
                $x[0] += $dx;
                $y[0] += $dy;
                for ($j = 0; $j < self::LEN - 1; ++$j) {
                    if ((abs($x[$j] - $x[$j + 1]) <= 1) and (abs($y[$j] - $y[$j + 1]) <= 1)) {
                        continue;
                    }
                    $tdx = min(1, max(-1, $x[$j] - $x[$j + 1]));
                    $tdy = min(1, max(-1, $y[$j] - $y[$j + 1]));
                    $x[$j + 1] += $tdx;
                    $y[$j + 1] += $tdy;
                }
                $visited[$x[self::LEN - 1] . ' ' . $y[self::LEN - 1]] = true;
            }
        }
        $ans2 = count($visited);
        return [strval($ans1), strval($ans2)];
    }
}

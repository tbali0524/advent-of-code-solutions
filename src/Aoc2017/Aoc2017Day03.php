<?php

declare(strict_types=1);

namespace TBali\Aoc2017;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2017 Day 3: Spiral Memory.
 *
 * Part 1: How many steps are required to carry the data from the square identified in your puzzle input
 *         all the way to the access port?
 * Part 2: What is the first value written that is larger than your puzzle input?
 *
 * @see https://adventofcode.com/2017/day/3
 */
final class Aoc2017Day03 extends SolutionBase
{
    public const YEAR = 2017;
    public const DAY = 3;
    public const TITLE = 'Spiral Memory';
    public const SOLUTIONS = [475, 279138];
    public const STRING_INPUT = '277678';
    public const EXAMPLE_SOLUTIONS = [[3, 23], [31, 1968]];
    public const EXAMPLE_STRING_INPUTS = ['12', '1024'];

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
        $n = intval($input[0]);
        // ---------- Part 1
        $r = 1;
        while (($r + 2) ** 2 < $n) {
            $r += 2;
        }
        $outer = $n - $r ** 2;
        $pos = $outer % ($r + 1);
        $dTangential = intdiv($r, 2) + 1;
        $dRadial = abs($dTangential - $pos);
        $ans1 = ($n <= 1 ? 0 : $dTangential + $dRadial);
        // ---------- Part 2
        [$x, $y] = [0, 0];
        [$dx, $dy] = [1, 0];
        $ans2 = 1;
        $memo[$y][$x] = $ans2;
        while ($ans2 <= $n) {
            $x += $dx;
            $y += $dy;
            $ans2 = 0;
            foreach ([[-1, -1], [0, -1], [1, -1], [1, 0], [1, 1], [0, 1], [-1, 1], [-1, 0]] as [$nx, $ny]) {
                [$x1, $y1] = [$x + $nx, $y + $ny];
                $ans2 += ($memo[$y1][$x1] ?? 0);
            }
            $memo[$y][$x] = $ans2;
            if (($dx == 1) and ($dy == 0)) {
                if (!isset($memo[$y - 1][$x])) {
                    [$dx, $dy] = [0, -1];
                }
            } elseif (($dx == 0) and ($dy == -1)) {
                if (!isset($memo[$y][$x - 1])) {
                    [$dx, $dy] = [-1, 0];
                }
            } elseif (($dx == -1) and ($dy == 0)) {
                if (!isset($memo[$y + 1][$x])) {
                    [$dx, $dy] = [0, 1];
                }
            } elseif (($dx == 0) and ($dy == 1)) {
                if (!isset($memo[$y][$x + 1])) {
                    [$dx, $dy] = [1, 0];
                }
            } else {
                throw new \Exception('Impossible');
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}

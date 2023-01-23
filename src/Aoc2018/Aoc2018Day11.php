<?php

declare(strict_types=1);

namespace TBali\Aoc2018;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2018 Day 11: Chronal Charge.
 *
 * Part 1: What is the X,Y coordinate of the top-left fuel cell of the 3x3 square with the largest total power?
 * Part 2: What is the X,Y,size identifier of the square with the largest total power?
 *
 * Topics: dynamic programming, sum of rectangle grid
 *
 * @see https://adventofcode.com/2018/day/11
 */
final class Aoc2018Day11 extends SolutionBase
{
    public const YEAR = 2018;
    public const DAY = 11;
    public const TITLE = 'Chronal Charge';
    public const SOLUTIONS = ['20,50', '238,278,9'];
    public const STRING_INPUT = '2866';
    public const EXAMPLE_SOLUTIONS = [['33,45', '90,269,16'], ['21,61', '232,251,12']];
    public const EXAMPLE_STRING_INPUTS = ['18', '42'];

    private const SIZE = 300;

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
        $serial = intval($input[0] ?? '0');
        // ---------- Part 1 + 2
        $powers = [];
        for ($y = 1; $y <= self::SIZE; ++$y) {
            for ($x = 1; $x <= self::SIZE; ++$x) {
                $id = 10 + $x;
                $powers[$y][$x] = intdiv((($id * $y + $serial) * $id) % 1000, 100) - 5;
            }
        }
        $sumPowers = [];
        for ($y = 1; $y <= self::SIZE; ++$y) {
            for ($x = 1; $x <= self::SIZE; ++$x) {
                $sumPowers[$y][$x] = $powers[$y][$x] + ($sumPowers[$y - 1][$x] ?? 0) + ($sumPowers[$y][$x - 1] ?? 0)
                    - ($sumPowers[$y - 1][$x - 1] ?? 0);
            }
        }
        $ans1 = '';
        $ans2 = '';
        $bestPower1 = 0;
        $bestPower2 = 0;
        for ($y = 1; $y <= self::SIZE; ++$y) {
            for ($x = 1; $x <= self::SIZE; ++$x) {
                $maxSize = intval(min(self::SIZE - $x + 1, self::SIZE - $y + 1));
                for ($size = 1; $size <= $maxSize; ++$size) {
                    $power = $sumPowers[$y + $size - 1][$x + $size - 1] - ($sumPowers[$y + $size - 1][$x - 1] ?? 0)
                        - ($sumPowers[$y - 1][$x + $size - 1] ?? 0) + ($sumPowers[$y - 1][$x - 1] ?? 0);
                    if (($size == 3) and ($power > $bestPower1)) {
                        $bestPower1 = $power;
                        $ans1 = $x . ',' . $y;
                    }
                    if ($power > $bestPower2) {
                        $bestPower2 = $power;
                        $ans2 = $x . ',' . $y . ',' . $size;
                    }
                }
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}

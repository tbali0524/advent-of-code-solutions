<?php

/*
https://adventofcode.com/2015/day/3
Part 1: How many houses receive at least one present?
Part 2: This year, how many houses receive at least one present?
*/

declare(strict_types=1);

namespace TBali\Aoc2015;

use TBali\Aoc\SolutionBase;

final class Aoc2015Day03 extends SolutionBase
{
    public const YEAR = 2015;
    public const DAY = 3;
    public const TITLE = 'Perfectly Spherical Houses in a Vacuum';
    public const SOLUTIONS = [2592, 2360];
    public const EXAMPLE_SOLUTIONS = [[4, 3], [2, 11]];
    public const EXAMPLE_STRING_INPUTS = ['^>v<', '^v^v^v^v^v'];

    private const DELTAS = ['>' => [1, 0], 'v' => [0, 1], '<' => [-1, 0], '^' => [0, -1]];

    /**
     * @param string[] $input
     *
     * @return array{string, string}
     */
    public function solve(array $input): array
    {
        $input = $input[0];
        // ---------- Part 1
        $ans1 = 1;
        $memo = [];
        $x = 0;
        $y = 0;
        $memo[$y][$x] = 1;
        foreach (str_split($input) as $dir) {
            [$dx, $dy] = self::DELTAS[$dir] ?? [0, 0];
            $x += $dx;
            $y += $dy;
            if (!isset($memo[$y][$x])) {
                ++$ans1;
            }
            $memo[$y][$x] = 1;
        }
        // ---------- Part 2
        $ans2 = 1;
        $memo = [];
        $x = [0, 0];
        $y = [0, 0];
        $memo[$y[0]][$x[0]] = 1;
        foreach (str_split($input) as $idx => $dir) {
            [$dx, $dy] = self::DELTAS[$dir] ?? [0, 0];
            $x[$idx % 2] += $dx;
            $y[$idx % 2] += $dy;
            if (!isset($memo[$y[$idx % 2]][$x[$idx % 2]])) {
                ++$ans2;
            }
            $memo[$y[$idx % 2]][$x[$idx % 2]] = 1;
        }
        return [strval($ans1), strval($ans2)];
    }
}

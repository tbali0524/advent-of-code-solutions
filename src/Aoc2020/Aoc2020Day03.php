<?php

/*
https://adventofcode.com/2020/day/3
Part 1: Starting at the top-left corner of your map and following a slope of right 3 and down 1,
how many trees would you encounter?
Part 2: What do you get if you multiply together the number of trees encountered on each of the listed slopes?
*/

declare(strict_types=1);

namespace TBali\Aoc2020;

use TBali\Aoc\SolutionBase;

final class Aoc2020Day03 extends SolutionBase
{
    public const YEAR = 2020;
    public const DAY = 3;
    public const TITLE = 'Toboggan Trajectory';
    public const SOLUTIONS = [211, 3584591857];
    public const EXAMPLE_SOLUTIONS = [[7, 336], [0, 0]];

    private const SLOPES = [[1, 1], [3, 1], [5, 1], [7, 1], [1, 2]];

    /**
     * @param string[] $input
     *
     * @return array{string, string}
     */
    public function solve(array $input): array
    {
        // ---------- Part 1
        $ans1 = 0;
        $maxY = count($input);
        $maxX = strlen($input[0]);
        $y = 0;
        $x = 0;
        while ($y < $maxY) {
            if ($input[$y][$x] == '#') {
                ++$ans1;
            }
            ++$y;
            $x = ($x + 3) % $maxX;
        }
        // ---------- Part 2
        $ans2 = 1;
        $maxY = count($input);
        $maxX = strlen($input[0]);
        foreach (self::SLOPES as $dxy) {
            [$dx, $dy] = $dxy;
            $y = 0;
            $x = 0;
            $count = 0;
            while ($y < $maxY) {
                if ($input[$y][$x] == '#') {
                    ++$count;
                }
                $y += $dy;
                $x = ($x + $dx) % $maxX;
            }
            $ans2 *= $count;
        }
        return [strval($ans1), strval($ans2)];
    }
}

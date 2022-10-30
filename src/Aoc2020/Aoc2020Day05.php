<?php

/*
https://adventofcode.com/2020/day/5
Part 1: What is the highest seat ID on a boarding pass?
Part 2: What is the ID of your seat?
*/

declare(strict_types=1);

namespace TBali\Aoc2020;

use TBali\Aoc\SolutionBase;

class Aoc2020Day05 extends SolutionBase
{
    public const YEAR = 2020;
    public const DAY = 5;
    public const TITLE = 'Binary Boarding';
    public const SOLUTIONS = [894, 579];
    public const EXAMPLE_SOLUTIONS = [[357, 0], [567, 0]];
    public const EXAMPLE_STRING_INPUTS = ['FBFBBFFRLR', 'BFFFBBFRRR'];

    /**
     * @param string[] $input
     *
     * @return array{string, string}
     */
    public function solve(array $input): array
    {
        // ---------- Part 1
        $ans1 = max(array_map(
            fn ($x) => bindec(strtr($x, 'FBLR', '0101')),
            $input
        ));
        // ---------- Part 2
        $max = 1 << strlen($input[0] ?? '');
        $seats = array_fill(0, $max, false);
        foreach ($input as $line) {
            $seats[bindec(strtr($line, 'FBLR', '0101'))] = true;
        }
        $ans2 = 0;
        while (($ans2 < $max) and !$seats[$ans2]) {
            ++$ans2;
        }
        while (($ans2 < $max) and $seats[$ans2]) {
            ++$ans2;
        }
        if (count($input) == 1) {
            $ans2 = 0;
        }
        return [strval($ans1), strval($ans2)];
    }
}

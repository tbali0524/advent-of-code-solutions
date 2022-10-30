<?php

/*
https://adventofcode.com/2015/day/17
Part 1: How many different combinations of containers can exactly fit all 150 liters of eggnog?
Part 2: Find the minimum number of containers that can exactly fit all 150 liters of eggnog.
    How many different ways can you fill that number of containers and still hold exactly 150 litres?
topics: combinations
*/

declare(strict_types=1);

namespace TBali\Aoc2015;

use TBali\Aoc\SolutionBase;

class Aoc2015Day17 extends SolutionBase
{
    public const YEAR = 2015;
    public const DAY = 17;
    public const TITLE = 'No Such Thing as Too Much';
    public const SOLUTIONS = [1304, 18];
    public const EXAMPLE_SOLUTIONS = [[0, 0], [0, 0]];

    private const TOTAL = 150;

    /**
     * @param string[] $input
     *
     * @return array{string, string}
     */
    public function solve(array $input): array
    {
        /** @var int[] */
        $input = array_map('intval', $input);
        // ---------- Part 1 + 2
        $ans1 = 0;
        rsort($input);
        $counts = array_fill(0, count($input), 0);
        for ($i = 0; $i < (1 << count($input)); ++$i) {
            $n = $i;
            $pos = 0;
            $sum = 0;
            $bits = 0;
            while (($n > 0) and ($sum < self::TOTAL)) {
                if (($n & 1) != 0) {
                    $sum += $input[$pos];
                    ++$bits;
                }
                ++$pos;
                $n >>= 1;
            }
            if (($n == 0) and ($sum == self::TOTAL)) {
                ++$ans1;
                ++$counts[$bits];
            }
        }
        $i = 0;
        while (($i < count($counts) - 1) and ($counts[$i] == 0)) {
            ++$i;
        }
        $ans2 = $counts[$i];
        return [strval($ans1), strval($ans2)];
    }
}

<?php

// @TODO: Part 2

/*
https://adventofcode.com/2015/day/25
Part 1: What code do you give the machine?
Part 2:
Topics: LCG, linear congruence
*/

declare(strict_types=1);

namespace TBali\Aoc2015;

use TBali\Aoc\SolutionBase;

final class Aoc2015Day25 extends SolutionBase
{
    public const YEAR = 2015;
    public const DAY = 25;
    public const TITLE = 'Let It Snow';
    public const SOLUTIONS = [19980801, 0];
    public const EXAMPLE_SOLUTIONS = [[31916031, 0], [27995004, 0]];

    /**
     * @param string[] $input
     *
     * @return array{string, string}
     */
    public function solve(array $input): array
    {
        // ---------- process input
        $a = explode(' ', $input[0]);
        if (count($a) != 19) {
            throw new \Exception('Invalid input');
        }
        $row = intval(substr($a[16], 0, -1));
        $column = intval(substr($a[18], 0, -1));
        $n = $row + $column - 2;
        $n = intdiv($n * ($n + 1), 2) + $column - 1;
        // ---------- Part 1
        $ans1 = $this->getPassword(20151125, $n);
        // ---------- Part 2
        $ans2 = 0;
        return [strval($ans1), strval($ans2)];
    }

    private function getPassword(int $start, int $steps = 1): int
    {
        $pw = $start;
        for ($i = 0; $i < $steps; ++$i) {
            $pw = ($pw * 252533) % 33554393;
        }
        return $pw;
    }
}

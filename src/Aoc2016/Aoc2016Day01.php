<?php

/*
https://adventofcode.com/2016/day/1
Part 1: How many blocks away is Easter Bunny HQ?
Part 2: How many blocks away is the first location you visit twice?
*/

declare(strict_types=1);

namespace TBali\Aoc2016;

use TBali\Aoc\SolutionBase;

final class Aoc2016Day01 extends SolutionBase
{
    public const YEAR = 2016;
    public const DAY = 1;
    public const TITLE = 'No Time for a Taxicab';
    public const SOLUTIONS = [262, 131];
    public const EXAMPLE_SOLUTIONS = [[8, 4], [0, 0]];
    public const EXAMPLE_STRING_INPUTS = ['R8, R4, R4, R8', ''];

    private const DELTAS = [[0, 1], [1, 0], [0, -1], [-1, 0]];
    private const TURNS = ['R' => 1, 'L' => -1];

    /**
     * @param string[] $input
     *
     * @return array{string, string}
     */
    public function solve(array $input): array
    {
        // ---------- Part 1
        $ans1 = 0;
        $x = 0;
        $y = 0;
        $direction = 0; // N
        foreach (explode(', ', $input[0]) as $instruction) {
            $turn = self::TURNS[$instruction[0]] ?? 0;
            $move = intval(substr($instruction, 1));
            $direction = ($direction + $turn + 4) % 4;
            [$dx, $dy] = self::DELTAS[$direction];
            $x += $dx * $move;
            $y += $dy * $move;
        }
        $ans1 = abs($x) + abs($y);
        // ---------- Part 2
        $ans2 = 0;
        $x = 0;
        $y = 0;
        $direction = 0; // N
        $memo = [];
        $memo[$y][$x] = true;
        foreach (explode(', ', $input[0]) as $instruction) {
            $turn = self::TURNS[$instruction[0]] ?? 0;
            $move = intval(substr($instruction, 1));
            $direction = ($direction + $turn + 4) % 4;
            [$dx, $dy] = self::DELTAS[$direction];
            for ($i = 0; $i < $move; ++$i) {
                $x += $dx;
                $y += $dy;
                if (isset($memo[$y][$x])) {
                    $ans2 = abs($x) + abs($y);
                    break 2;
                }
                $memo[$y][$x] = true;
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}

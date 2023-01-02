<?php

declare(strict_types=1);

namespace TBali\Aoc2017;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2017 Day 11: Hex Ed.
 *
 * Part 1: Starting where he started, you need to determine the fewest number of steps required to reach him.
 * Part 2: How many steps away is the furthest he ever got from his starting position?
 *
 * @see https://adventofcode.com/2017/day/11
 */
final class Aoc2017Day11 extends SolutionBase
{
    public const YEAR = 2017;
    public const DAY = 11;
    public const TITLE = 'Hex Ed';
    public const SOLUTIONS = [824, 1548];
    public const EXAMPLE_SOLUTIONS = [[3, 3], [3, 3], [2, 2]];
    public const EXAMPLE_STRING_INPUTS = ['ne,ne,ne', 'se,sw,se,sw,sw', 'ne,ne,s,s'];

    /**
     * Hex grid represented as cube coordinates [q, r, s].
     *
     * @see https://www.redblobgames.com/grids/hexagons/#coordinates
     */
    private const DELTAS = [
        'n' => [0, -1, 1],
        's' => [0, 1, -1],
        'nw' => [-1, 0, 1],
        'se' => [1, 0, -1],
        'ne' => [1, -1, 0],
        'sw' => [-1, 1, 0],
    ];

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
        $dirs = explode(',', $input[0] ?? '');
        // ---------- Part 1 + 2
        $ans1 = 0;
        $ans2 = 0;
        [$q, $r, $s] = [0, 0, 0];
        foreach ($dirs as $dir) {
            if (!isset(self::DELTAS[$dir])) {
                throw new \Exception('Invalid input');
            }
            [$dq, $dr, $ds] = self::DELTAS[$dir];
            [$q, $r, $s] = [$q + $dq, $r + $dr, $s + $ds];
            $ans1 = intdiv(abs($q) + abs($r) + abs($s), 2);
            $ans2 = intval(max($ans1, $ans2));
        }
        return [strval($ans1), strval($ans2)];
    }
}

<?php

declare(strict_types=1);

namespace TBali\Aoc2016;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2016 Day 3: Squares With Three Sides.
 *
 * Part 1: In your puzzle input, how many of the listed triangles are possible?
 * Part 2: In your puzzle input, and instead reading by columns, how many of the listed triangles are possible?
 *
 * @see https://adventofcode.com/2016/day/3
 */
final class Aoc2016Day03 extends SolutionBase
{
    public const YEAR = 2016;
    public const DAY = 3;
    public const TITLE = 'Squares With Three Sides';
    public const SOLUTIONS = [982, 1826];
    public const EXAMPLE_SOLUTIONS = [[0, 0], [0, 0]];

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
        $data = [];
        foreach ($input as $line) {
            $data[] = sscanf($line, '%d %d %d') ?? [];
        }
        // ---------- Part 1
        $ans1 = 0;
        foreach ($data as $sides) {
            sort($sides);
            if (($sides[0] ?? 0) + ($sides[1] ?? 0) > ($sides[2] ?? 0)) {
                ++$ans1;
            }
        }
        // ---------- Part 2
        $ans2 = 0;
        for ($x = 0; $x < 3; ++$x) {
            for ($y = 0; $y < count($data); $y += 3) {
                $sides = [$data[$y][$x] ?? 0, $data[$y + 1][$x] ?? 0, $data[$y + 2][$x] ?? 0];
                sort($sides);
                if ($sides[0] + $sides[1] > $sides[2]) {
                    ++$ans2;
                }
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}

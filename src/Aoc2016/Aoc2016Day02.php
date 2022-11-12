<?php

declare(strict_types=1);

namespace TBali\Aoc2016;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2016 Day 2: Bathroom Security.
 *
 * Part 1: What is the bathroom code?
 * Part 2: Using the same instructions in your puzzle input, what is the correct bathroom code?
 *
 * Topics: walk simulation
 *
 * @see https://adventofcode.com/2016/day/2
 */
final class Aoc2016Day02 extends SolutionBase
{
    public const YEAR = 2016;
    public const DAY = 2;
    public const TITLE = 'Bathroom Security';
    public const SOLUTIONS = [24862, '46C91'];
    public const EXAMPLE_SOLUTIONS = [[1985, '5DB3'], [0, 0]];

    private const DELTAS = ['U' => [0, -1], 'R' => [1, 0], 'D' => [0, 1], 'L' => [-1, 0]];
    private const KEYS_PART2 = [
        '00100',
        '02340',
        '56789',
        '0ABC0',
        '00D00',
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
        // ---------- Part 1
        $x = 1;
        $y = 0;
        $ans1 = 0;
        foreach ($input as $line) {
            for ($i = 0; $i < strlen($line); ++$i) {
                [$dx, $dy] = self::DELTAS[$line[$i]] ?? [0, 0];
                [$x1, $y1] = [$x + $dx, $y + $dy];
                if (($x1 < 0) or ($x1 >= 3) or ($y1 < 0) or ($y1 >= 3)) {
                    continue;
                }
                [$x, $y] = [$x1, $y1];
            }
            $ans1 = 10 * $ans1 + $y * 3 + $x + 1;
        }
        // ---------- Part 2
        $x = 0;
        $y = 2;
        $ans2 = '';
        foreach ($input as $line) {
            for ($i = 0; $i < strlen($line); ++$i) {
                [$dx, $dy] = self::DELTAS[$line[$i]] ?? [0, 0];
                [$x1, $y1] = [$x + $dx, $y + $dy];
                if (
                    ($x1 < 0) or ($x1 >= 5) or ($y1 < 0) or ($y1 >= 5)
                    or (self::KEYS_PART2[$y1][$x1] == '0')
                ) {
                    continue;
                }
                [$x, $y] = [$x1, $y1];
            }
            $ans2 .= self::KEYS_PART2[$y][$x];
        }
        return [strval($ans1), $ans2];
    }
}

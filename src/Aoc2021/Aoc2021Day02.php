<?php

declare(strict_types=1);

namespace TBali\Aoc2021;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2021 Day 2: Dive!.
 *
 * Part 1: What is the checksum for your list of box IDs?
 * Part 2: What do you get if you multiply your final horizontal position by your final depth?
 *
 * @see https://adventofcode.com/2021/day/2
 */
final class Aoc2021Day02 extends SolutionBase
{
    public const YEAR = 2021;
    public const DAY = 2;
    public const TITLE = 'Dive!';
    public const SOLUTIONS = [2117664, 2073416724];
    public const EXAMPLE_SOLUTIONS = [[150, 900]];

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
        $x = 0;
        $y = 0;
        foreach ($input as $line) {
            $a = explode(' ', $line);
            $param = intval($a[1] ?? throw new \Exception('Invalid input'));
            match ($a[0]) {
                'forward' => $x += $param,
                'up' => $y -= $param,
                'down' => $y += $param,
                default => throw new \Exception('Invalid input'),
            };
        }
        $ans1 = $x * $y;
        // ---------- Part 2
        $x = 0;
        $y = 0;
        $aim = 0;
        foreach ($input as $line) {
            $a = explode(' ', $line);
            $param = intval($a[1]);
            if ($a[0] == 'forward') {
                $x += $param;
                $y += $param * $aim;
            } elseif ($a[0] == 'up') {
                $aim -= $param;
            } elseif ($a[0] == 'down') {
                $aim += $param;
            }
        }
        $ans2 = $x * $y;
        return [strval($ans1), strval($ans2)];
    }
}

<?php

declare(strict_types=1);

namespace TBali\Aoc2022;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2022 Day 1: Calorie Counting.
 *
 * Part 1: Find the Elf carrying the most Calories. How many total Calories is that Elf carrying?
 * Part 2: Find the top three Elves carrying the most Calories. How many Calories are those Elves carrying in total?
 *
 * @see https://adventofcode.com/2022/day/1
 */
final class Aoc2022Day01 extends SolutionBase
{
    public const YEAR = 2022;
    public const DAY = 1;
    public const TITLE = 'Calorie Counting';
    public const SOLUTIONS = [72070, 211805];
    public const EXAMPLE_SOLUTIONS = [[24000, 45000], [0, 0]];

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
        // ---------- Parse input
        $calories = [[]];
        $idxElf = 0;
        foreach ($input as $line) {
            if ($line == '') {
                ++$idxElf;
                continue;
            }
            $calories[$idxElf][] = intval($line);
        }
        // ---------- Part 1 + 2
        $cals = array_map('array_sum', $calories);
        $ans1 = max($cals);
        rsort($cals);
        $ans2 = ($cals[0] ?? 0) + ($cals[1] ?? 0) + ($cals[2] ?? 0);
        return [strval($ans1), strval($ans2)];
    }
}

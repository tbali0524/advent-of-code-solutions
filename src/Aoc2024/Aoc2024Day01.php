<?php

declare(strict_types=1);

namespace TBali\Aoc2024;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2024 Day 1: Historian Hysteria.
 *
 * Part 1: What is the total distance between your lists?
 * Part 2: Once again consider your left and right lists. What is their similarity score?
 *
 * @see https://adventofcode.com/2024/day/1
 */
final class Aoc2024Day01 extends SolutionBase
{
    public const YEAR = 2024;
    public const DAY = 1;
    public const TITLE = 'Historian Hysteria';
    public const SOLUTIONS = [936063, 23150395];
    public const EXAMPLE_SOLUTIONS = [[11, 31]];

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
        /** @var array<int, array<int, int>> */
        $data = array_map(
            static fn (string $line): array => array_map(intval(...), explode('   ', $line)),
            $input
        );
        if (array_any($data, static fn (array $x): bool => count($x) != 2)) {
            throw new \Exception('Invalid input');
        }
        $left = array_map(static fn (array $x): int => $x[0], $data);
        $right = array_map(static fn (array $x): int => $x[1], $data);
        // ---------- Part 1
        $ans1 = 0;
        sort($left);
        sort($right);
        for ($i = 0; $i < count($left); ++$i) {
            $ans1 += abs($left[$i] - $right[$i]);
        }
        // ---------- Part 2
        $ans2 = 0;
        $start = 0;
        foreach ($left as $left_item) {
            $count = 0;
            $j = $start;
            while (($j < count($right)) and ($right[$j] < $left_item)) {
                ++$j;
            }
            $start = $j;
            while (($j < count($right)) and ($right[$j] == $left_item)) {
                ++$count;
                ++$j;
            }
            $ans2 += $left_item * $count;
        }
        return [strval($ans1), strval($ans2)];
    }
}

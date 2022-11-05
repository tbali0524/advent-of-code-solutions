<?php

declare(strict_types=1);

namespace TBali\Aoc2020;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2020 Day 1: Report Repair.
 *
 * Part 1: Find the two entries that sum to 2020 and then multiply those two numbers together.
 * Part 2: What is the product of the three entries that sum to 2020?
 *
 * @see https://adventofcode.com/2020/day/1
 */
final class Aoc2020Day01 extends SolutionBase
{
    public const YEAR = 2020;
    public const DAY = 1;
    public const TITLE = 'Report Repair';
    public const SOLUTIONS = [988771, 171933104];
    public const EXAMPLE_SOLUTIONS = [[514579, 241861950], [0, 0]];

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
        /** @var array<int, int> */
        $input = array_map('intval', $input);
        // ---------- Part 1
        $ans1 = 0;
        $visited = [];
        foreach ($input as $i) {
            if (isset($visited[2020 - $i])) {
                $ans1 = $i * (2020 - $i);
                break;
            }
            $visited[$i] = true;
        }
        // ---------- Part 2
        $ans2 = 0;
        $visited = [];
        foreach ($input as $idx => $i) {
            foreach ($input as $idx2 => $j) {
                if ($idx != $idx2) {
                    $visited[$i + $j] = $i * $j;
                }
            }
        }
        foreach ($input as $i) {
            if (isset($visited[2020 - $i])) {
                $ans2 = $i * $visited[2020 - $i];
                break;
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}

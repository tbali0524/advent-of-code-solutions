<?php

declare(strict_types=1);

namespace TBali\Aoc2017;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2017 Day 6: Memory Reallocation.
 *
 * Part 1: Given the initial block counts in your puzzle input, how many redistribution cycles must be completed
 *         before a configuration is produced that has been seen before?
 * Part 2: How many cycles are in the infinite loop that arises from the configuration in your puzzle input?
 *
 * @see https://adventofcode.com/2017/day/6
 */
final class Aoc2017Day06 extends SolutionBase
{
    public const YEAR = 2017;
    public const DAY = 6;
    public const TITLE = 'Memory Reallocation';
    public const SOLUTIONS = [7864, 1695];
    public const EXAMPLE_SOLUTIONS = [[5, 4]];

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
        $data = array_map(intval(...), explode("\t", $input[0] ?? ''));
        // ---------- Part 1 + 2
        $ans1 = 0;
        $ans2 = 0;
        $banks = $data;
        $memo = [implode(' ', $banks) => 0];
        $step = 0;
        while (true) {
            $idxMax = 0;
            $max = ~PHP_INT_MAX;
            for ($idxBank = 0; $idxBank < count($data); ++$idxBank) {
                if ($banks[$idxBank] > $max) {
                    $idxMax = $idxBank;
                    $max = $banks[$idxBank];
                }
            }
            $toAdd = intdiv($max, count($data));
            $remainder = $max % count($data);
            $banks[$idxMax] = 0;
            for ($i = 1; $i <= count($data); ++$i) {
                $banks[($idxMax + $i) % count($data)] += $toAdd + ($i <= $remainder ? 1 : 0);
            }
            ++$step;
            $hash = implode(' ', $banks);
            if (isset($memo[$hash])) {
                $ans1 = $step;
                $ans2 = $step - $memo[$hash];
                break;
            }
            $memo[$hash] = $step;
        }
        return [strval($ans1), strval($ans2)];
    }
}

<?php

declare(strict_types=1);

namespace TBali\Aoc2025;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2025 Day 5: Cafeteria.
 *
 * @see https://adventofcode.com/2025/day/5
 */
final class Aoc2025Day05 extends SolutionBase
{
    public const YEAR = 2025;
    public const DAY = 5;
    public const TITLE = 'Cafeteria';
    public const SOLUTIONS = [607, 342433357244012];
    public const EXAMPLE_SOLUTIONS = [[3, 14]];

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
        $ranges = [];
        $ids = [];
        $i = 0;
        while ($input[$i] != '') {
            $a = array_map(intval(...), explode('-', $input[$i]));
            if (count($a) != 2) {
                throw new \Exception('Invalid input');
            }
            $ranges[] = $a;
            ++$i;
        }
        ++$i;
        while ($i < count($input)) {
            $ids[] = intval($input[$i]);
            ++$i;
        }
        // ---------- Part 1
        $ans1 = 0;
        foreach ($ids as $id) {
            foreach ($ranges as [$from, $to]) {
                if ($from <= $id && $id <= $to) {
                    ++$ans1;
                    break;
                }
            }
        }
        // ---------- Part 2
        $ans2 = 0;
        $froms = [];
        foreach ($ranges as [$from, $to]) {
            $froms[] = $from;
            $froms[] = $to + 1;
        }
        sort($froms);
        $froms = array_values(array_unique($froms));
        $count = count($froms) - 1;
        $fresh = array_fill(0, $count, false) ?: [];
        foreach ($ranges as [$from, $to]) {
            for ($i = 0; $i < $count; ++$i) {
                if ($from <= $froms[$i] && $froms[$i + 1] - 1 <= $to) {
                    $fresh[$i] = true;
                }
            }
        }
        for ($i = 0; $i < $count; ++$i) {
            if ($fresh[$i]) {
                $ans2 += $froms[$i + 1] - $froms[$i];
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}

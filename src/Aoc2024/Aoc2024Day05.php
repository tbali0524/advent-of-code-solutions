<?php

declare(strict_types=1);

namespace TBali\Aoc2024;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2024 Day 5: Print Queue.
 *
 * @see https://adventofcode.com/2024/day/5
 */
final class Aoc2024Day05 extends SolutionBase
{
    public const YEAR = 2024;
    public const DAY = 5;
    public const TITLE = 'Print Queue';
    public const SOLUTIONS = [5639, 5273];
    public const EXAMPLE_SOLUTIONS = [[143, 123]];

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
        $rules = [];
        $pagelists = [];
        $i = 0;
        while (($i < count($input)) and ($input[$i] != '')) {
            $items = array_map(intval(...), explode('|', $input[$i]));
            if (count($items) != 2) {
                throw new \Exception('rules must contain two items separated by `|`');
            }
            $rules[($items[0] << 32) | $items[1]] = true;
            $rules[($items[1] << 32) | $items[0]] = false;
            ++$i;
        }
        if ($i == count($input)) {
            throw new \Exception('missing page list, must come after after rules and an empty line');
        }
        ++$i;
        while ($i < count($input)) {
            $pagelists[] = array_map(intval(...), explode(',', $input[$i]));
            ++$i;
        }
        // ---------- Part 1
        $ans1 = 0;
        $incorrects = [];
        foreach ($pagelists as $idx_row => $pagelist) {
            $is_ok = true;
            foreach ($pagelist as $idx => $page) {
                for ($i = 0; $i < $idx; ++$i) {
                    $prev = $pagelist[$i];
                    if (!($rules[($prev << 32) | $page] ?? true)) {
                        $is_ok = false;
                        break 2;
                    }
                }
            }
            if ($is_ok) {
                $ans1 += $pagelist[intdiv(count($pagelist), 2)];
            } else {
                $incorrects[] = $idx_row;
            }
        }
        // ---------- Part 2
        $ans2 = 0;
        foreach ($incorrects as $idx_row) {
            $count_prevs = [];
            foreach ($pagelists[$idx_row] as $idx => $page) {
                $count_prevs[] = [$page, 0];
                foreach ($pagelists[$idx_row] as $prev) {
                    if ($rules[($prev << 32) | $page] ?? false) {
                        ++$count_prevs[$idx][1];
                    }
                }
            }
            usort($count_prevs, static fn (array $a, array $b): int => $a[1] <=> $b[1]);
            $ans2 += $count_prevs[intdiv(count($count_prevs), 2)][0];
        }
        return [strval($ans1), strval($ans2)];
    }
}

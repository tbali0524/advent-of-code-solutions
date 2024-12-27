<?php

declare(strict_types=1);

namespace TBali\Aoc2024;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2024 Day 19: Linen Layout.
 *
 * @see https://adventofcode.com/2024/day/19
 */
final class Aoc2024Day19 extends SolutionBase
{
    public const YEAR = 2024;
    public const DAY = 19;
    public const TITLE = 'Linen Layout';
    public const SOLUTIONS = [247, 692596560138745];
    public const EXAMPLE_SOLUTIONS = [[6, 16]];

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
        if ((count($input) < 3) or ($input[1] != '')) {
            throw new \Exception('patterns and designs must be separated by an empty line');
        }
        $patterns = explode(', ', $input[0]);
        $max_pattern = intval(max(array_map(strlen(...), $patterns)));
        $designs = array_slice($input, 2);
        // ---------- Part 1 + 2
        $lookup = [];
        foreach ($patterns as $pattern) {
            $lookup[$pattern] = true;
        }
        $ans1 = 0;
        $ans2 = 0;
        foreach ($designs as $design) {
            $found_sol = false;
            $has_partial = [];
            $q = new \SplMinHeap();
            /** @var \SplMinHeap<int> $q */
            $has_partial[0] = 1;
            $q->insert(0);
            while (!$q->isEmpty()) {
                $pos = intval($q->extract());
                $prev_sols = $has_partial[$pos] ?? 1;
                if ($pos == strlen($design)) {
                    if (!$found_sol) {
                        ++$ans1;
                        $found_sol = true;
                    }
                    $ans2 += $has_partial[$pos] ?? 1;
                    continue;
                }
                $max_to_pos = intval(min(strlen($design), $pos + $max_pattern));
                for ($to_pos = $pos + 1; $to_pos <= $max_to_pos; ++$to_pos) {
                    if (!isset($lookup[substr($design, $pos, $to_pos - $pos)])) {
                        continue;
                    }
                    if (!isset($has_partial[$to_pos])) {
                        $q->insert($to_pos);
                    }
                    $has_partial[$to_pos] = ($has_partial[$to_pos] ?? 0) + $prev_sols;
                }
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}

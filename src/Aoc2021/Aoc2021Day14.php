<?php

declare(strict_types=1);

namespace TBali\Aoc2021;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2021 Day 14: Extended Polymerization.
 *
 * Part 1: What do you get if you take the quantity of the most common element
 *         and subtract the quantity of the least common element?
 * Part 2: Apply 40 steps of pair insertion to the polymer template and find the most and least common elements
 *         in the result.
 *
 * @see https://adventofcode.com/2021/day/14
 */
final class Aoc2021Day14 extends SolutionBase
{
    public const YEAR = 2021;
    public const DAY = 14;
    public const TITLE = 'Extended Polymerization';
    public const SOLUTIONS = [2988, 3572761917024];
    public const EXAMPLE_SOLUTIONS = [[1588, 2188189693529]];

    private const MAX_STEPS_PART1 = 10;
    private const MAX_STEPS_PART2 = 40;

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
        if ((count($input) < 3) or (strlen($input[0]) < 2) or ($input[1] != '')) {
            throw new \Exception('Invalid input');
        }
        $template = $input[0];
        $rules = [];
        for ($i = 2; $i < count($input); ++$i) {
            if ((strlen($input[$i]) != 7) or (substr($input[$i], 2, 4) != ' -> ')) {
                throw new \Exception('Invalid input');
            }
            $rules[substr($input[$i], 0, 2)] = $input[$i][6];
        }
        // ---------- Part 1
        $polymer = $template;
        for ($step = 0; $step < self::MAX_STEPS_PART1; ++$step) {
            $nextPolymer = $polymer[0];
            for ($i = 1; $i < strlen($polymer); ++$i) {
                $nextPolymer .= ($rules[$polymer[$i - 1] . $polymer[$i]] ?? '') . $polymer[$i];
            }
            $polymer = $nextPolymer;
        }
        $counts = array_count_values(str_split($polymer));
        if (count($counts) == 0) {
            throw new \Exception('Invalid input');
        }
        sort($counts);
        $ans1 = $counts[array_key_last($counts)] - $counts[array_key_first($counts)];
        // ---------- Part 2
        $first = $template[0];
        $last = $template[strlen($template) - 1];
        $pairs = [];
        for ($i = 1; $i < strlen($template); ++$i) {
            $pair = $template[$i - 1] . $template[$i];
            $pairs[$pair] = ($pairs[$pair] ?? 0) + 1;
        }
        for ($step = 0; $step < self::MAX_STEPS_PART2; ++$step) {
            $nextPairs = [];
            foreach ($pairs as $pair => $count) {
                $mid = $rules[$pair] ?? '';
                $pair1 = $pair[0] . $mid;
                $pair2 = $mid . $pair[1];
                $nextPairs[$pair1] = ($nextPairs[$pair1] ?? 0) + $count;
                $nextPairs[$pair2] = ($nextPairs[$pair2] ?? 0) + $count;
            }
            $pairs = $nextPairs;
        }
        $counts = [];
        foreach ($pairs as $pair => $count) {
            $counts[$pair[0]] = ($counts[$pair[0]] ?? 0) + $count;
            $counts[$pair[1]] = ($counts[$pair[1]] ?? 0) + $count;
        }
        $counts[$first] = ($counts[$first] ?? 0) + 1;
        $counts[$last] = ($counts[$last] ?? 0) + 1;
        sort($counts);
        $ans2 = intdiv($counts[array_key_last($counts)] - $counts[array_key_first($counts)], 2);
        return [strval($ans1), strval($ans2)];
    }
}

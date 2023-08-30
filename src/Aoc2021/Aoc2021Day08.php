<?php

declare(strict_types=1);

namespace TBali\Aoc2021;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2021 Day 8: Seven Segment Search.
 *
 * Part 1: In the output values, how many times do digits 1, 4, 7, or 8 appear?
 * Part 2: What do you get if you add up all of the output values?
 *
 * @see https://adventofcode.com/2021/day/8
 */
final class Aoc2021Day08 extends SolutionBase
{
    public const YEAR = 2021;
    public const DAY = 8;
    public const TITLE = 'Seven Segment Search';
    public const SOLUTIONS = [383, 998900];
    public const EXAMPLE_SOLUTIONS = [[0, 5353], [26, 61229]];

    private const DIGIT_SEGMENTS = [
        0 => [0, 1, 2, 4, 5, 6],
        1 => [2, 5],
        2 => [0, 2, 3, 4, 6],
        3 => [0, 2, 3, 5, 6],
        4 => [1, 2, 3, 5],
        5 => [0, 1, 3, 5, 6],
        6 => [0, 1, 3, 4, 5, 6],
        7 => [0, 2, 5],
        8 => [0, 1, 2, 3, 4, 5, 6],
        9 => [0, 1, 2, 3, 5, 6],
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
        // ---------- Parse input
        $digitPatterns = array_fill(0, count($input), []);
        $outputs = array_fill(0, count($input), []);
        foreach ($input as $idx => $line) {
            $a = explode(' | ', $line);
            if (count($a) != 2) {
                throw new \Exception('Invalid input');
            }
            foreach (explode(' ', $a[0]) as $pattern) {
                $letters = str_split($pattern);
                sort($letters);
                $digitPatterns[$idx][] = $letters;
            }
            foreach (explode(' ', $a[1]) as $pattern) {
                $letters = str_split($pattern);
                sort($letters);
                $outputs[$idx][] = implode('', $letters);
            }
        }
        for ($idx = 0; $idx < count($digitPatterns); ++$idx) {
            usort($digitPatterns[$idx], static fn (array $a, array $b): int => count($a) <=> count($b));
        }
        // ---------- Part 1
        $ans1 = 0;
        foreach ($outputs as $patterns) {
            foreach ($patterns as $pattern) {
                if (in_array(strlen($pattern), [2, 3, 4, 7])) {
                    ++$ans1;
                }
            }
        }
        // ---------- Part 2
        $ans2 = 0;
        foreach ($digitPatterns as $idx => $patterns) {
            $segments = [];
            $segments[0] = current(array_diff($patterns[1], $patterns[0]));
            $freq = array_count_values(array_merge(...$patterns));
            // # of times a given  segment is used in all digits: 8, 6, 8, 7, 4, 9, 7
            $segments[2] = current(array_diff(array_keys($freq, 8), [$segments[0]]));
            $segments[1] = current(array_keys($freq, 6));
            $segments[4] = current(array_keys($freq, 4));
            $segments[5] = current(array_keys($freq, 9));
            $segments[3] = current(array_diff(array_diff($patterns[2], $patterns[0]), [$segments[1]]));
            $segments[6] = current(array_diff(array_keys($freq, 7), [$segments[3]]));
            $map = [];
            for ($digit = 0; $digit < 10; ++$digit) {
                $digitSegments = [];
                foreach (self::DIGIT_SEGMENTS[$digit] as $idxSegment) {
                    $digitSegments[] = $segments[$idxSegment];
                }
                sort($digitSegments);
                $map[implode('', $digitSegments)] = $digit;
            }
            $value = 0;
            foreach ($outputs[$idx] as $pattern) {
                $value = 10 * $value + $map[$pattern];
            }
            $ans2 += $value;
        }
        return [strval($ans1), strval($ans2)];
    }
}

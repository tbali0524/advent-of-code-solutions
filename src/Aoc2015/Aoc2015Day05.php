<?php

declare(strict_types=1);

namespace TBali\Aoc2015;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2015 Day 5: Doesn't He Have Intern-Elves For This?.
 *
 * Part 1: How many strings are nice?
 * Part 2: How many strings are nice under these new rules?
 *
 * Topics: string validation
 *
 * @see https://adventofcode.com/2015/day/5
 */
final class Aoc2015Day05 extends SolutionBase
{
    public const YEAR = 2015;
    public const DAY = 5;
    public const TITLE = 'Doesn\'t He Have Intern-Elves For This?';
    public const SOLUTIONS = [238, 69];
    public const EXAMPLE_SOLUTIONS = [[2, 0], [0, 2]];

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
        $ans1 = 0;
        foreach ($input as $line) {
            $count = 0;
            foreach (str_split('aeiou') as $needle) {
                $count += substr_count($line, $needle);
            }
            if ($count < 3) {
                continue;
            }
            $isNice = false;
            for ($i = 0; $i < 26; ++$i) {
                $c = chr(ord('a') + $i);
                if (str_contains($line, $c . $c)) {
                    $isNice = true;
                    break;
                }
            }
            if (!$isNice) {
                continue;
            }
            foreach (['ab', 'cd', 'pq', 'xy'] as $needle) {
                if (str_contains($line, $needle)) {
                    $isNice = false;
                    break;
                }
            }
            if ($isNice) {
                ++$ans1;
            }
        }
        // ---------- Part 2
        $ans2 = 0;
        foreach ($input as $line) {
            $firstPos = [];
            $isNice = false;
            for ($i = 1; $i < strlen($line); ++$i) {
                $pair = $line[$i - 1] . $line[$i];
                if (isset($firstPos[$pair])) {
                    if ($i - $firstPos[$pair] >= 2) {
                        $isNice = true;
                        break;
                    }
                    continue;
                }
                $firstPos[$pair] = $i;
            }
            if (!$isNice) {
                continue;
            }
            $isNice = false;
            for ($i = 2; $i < strlen($line); ++$i) {
                if ($line[$i] == $line[$i - 2]) {
                    $isNice = true;
                    break;
                }
            }
            if ($isNice) {
                ++$ans2;
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}

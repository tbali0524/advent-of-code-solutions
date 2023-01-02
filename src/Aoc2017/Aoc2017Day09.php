<?php

declare(strict_types=1);

namespace TBali\Aoc2017;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2017 Day 9: Stream Processing.
 *
 * Part 1: What is the total score for all groups in your input?
 * Part 2: How many non-canceled characters are within the garbage in your puzzle input?
 *
 * Topics: parsing, state machine
 *
 * @see https://adventofcode.com/2017/day/9
 */
final class Aoc2017Day09 extends SolutionBase
{
    public const YEAR = 2017;
    public const DAY = 9;
    public const TITLE = 'Stream Processing';
    public const SOLUTIONS = [14204, 6622];
    public const EXAMPLE_SOLUTIONS = [[50, 0], [0, 32]];

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
        // ---------- Part 1 + 2
        $ans1 = 0;
        $ans2 = 0;
        foreach ($input as $line) {
            $depth = 0;
            $inIgnore = false;
            $inGarbage = false;
            $i = -1;
            while ($i < strlen($line) - 1) {
                ++$i;
                if ($inIgnore) {
                    $inIgnore = false;
                    continue;
                }
                if ($line[$i] == '!') {
                    $inIgnore = true;
                    continue;
                }
                if ($inGarbage) {
                    if ($line[$i] == '>') {
                        $inGarbage = false;
                        continue;
                    }
                    ++$ans2;
                    continue;
                }
                if ($line[$i] == '<') {
                    $inGarbage = true;
                    continue;
                }
                if ($line[$i] == '{') {
                    ++$depth;
                    continue;
                }
                if ($line[$i] == '}') {
                    $ans1 += $depth;
                    --$depth;
                    continue;
                }
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}

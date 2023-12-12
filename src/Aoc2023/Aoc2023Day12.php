<?php

declare(strict_types=1);

namespace TBali\Aoc2023;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2023 Day 12: Hot Springs.
 *
 * Part 1: What is the sum of those counts?
 * Part 2: Unfold your condition records; what is the new sum of possible arrangement counts?
 *
 * @see https://adventofcode.com/2023/day/12
 */
final class Aoc2023Day12 extends SolutionBase
{
    public const YEAR = 2023;
    public const DAY = 12;
    public const TITLE = 'Hot Springs';
    public const SOLUTIONS = [8193, 0];
    public const EXAMPLE_SOLUTIONS = [[21, 0]]; // part two: 525152

    private const OPERATIONAL = '.';
    private const DAMAGED = '#';
    private const UNKNOWN = '?';

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
        $records = [];
        $sizes = [];
        $unknowns = [];
        foreach ($input as $idx => $line) {
            $a = explode(' ', $line);
            if (count($a) != 2) {
                throw new \Exception('Invalid input');
            }
            $records[] = $a[0];
            $sizes[] = array_map(intval(...), explode(',', $a[1]));
            $unknowns[] = [];
            for ($i = 0; $i < strlen($records[$idx]); ++$i) {
                if ($records[$idx][$i] == self::UNKNOWN) {
                    $unknowns[$idx][] = $i;
                }
            }
        }
        // ---------- Part 1
        $ans1 = 0;
        for ($i = 0; $i < count($input); ++$i) {
            $maxUnknown = count($unknowns[$i]);
            $maxBitmask = 1 << $maxUnknown;
            for ($mask = 0; $mask < $maxBitmask; ++$mask) {
                $record = $records[$i];
                foreach ($unknowns[$i] as $k => $pos) {
                    $record[$pos] = ((($mask >> $k) & 1) == 0 ? self::OPERATIONAL : self::DAMAGED);
                }
                $pattern = [];
                $inGroup = false;
                for ($j = 0; $j < strlen($record); ++$j) {
                    if ($record[$j] == self::DAMAGED) {
                        if ($inGroup) {
                            ++$pattern[count($pattern) - 1];
                        } else {
                            $pattern[] = 1;
                            $inGroup = true;
                        }
                    } else {
                        $inGroup = false;
                    }
                }
                if ($pattern == $sizes[$i]) {
                    ++$ans1;
                }
            }
        }
        // ---------- Part 2
        $ans2 = 0;
        return [strval($ans1), strval($ans2)];
    }
}

<?php

declare(strict_types=1);

namespace TBali\Aoc2020;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2020 Day 14: Docking Data.
 *
 * Part 1: What is the sum of all values left in memory after it completes?
 * Part 2: Execute the initialization program using an emulator for a version 2 decoder chip.
 *         What is the sum of all values left in memory after it completes?
 *
 * Topics: assembly simulation
 *
 * @see https://adventofcode.com/2020/day/14
 */
final class Aoc2020Day14 extends SolutionBase
{
    public const YEAR = 2020;
    public const DAY = 14;
    public const TITLE = 'Docking Data';
    public const SOLUTIONS = [7817357407588, 4335927555692];
    public const EXAMPLE_SOLUTIONS = [[165, 0], [0, 208]];

    private const BIT_SIZE = 36;

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
        $mem = [];
        $mask = str_repeat('X', self::BIT_SIZE);
        foreach ($input as $line) {
            $a = explode(' = ', $line);
            if (count($a) != 2) {
                throw new \Exception('Invalid input');
            }
            if ($a[0] == 'mask') {
                $mask = $a[1];
                continue;
            }
            if (substr($a[0], 0, 4) != 'mem[') {
                throw new \Exception('Invalid input');
            }
            $loc = intval(substr($a[0], 4, -1));
            $value = intval($a[1]);
            $maskedValue = 0;
            for ($i = 0; $i < self::BIT_SIZE; ++$i) {
                match ($mask[$i]) {
                    '0' => 0,
                    '1' => $maskedValue |= (1 << (self::BIT_SIZE - 1 - $i)),
                    'X' => $maskedValue |= ($value & (1 << (self::BIT_SIZE - 1 - $i))),
                    default => throw new \Exception('Invalid mask'),
                };
            }
            $mem[$loc] = $maskedValue;
        }
        $ans1 = array_sum($mem);
        // ---------- Part 2
        $mem = [];
        $mask = str_repeat('X', self::BIT_SIZE);
        foreach ($input as $line) {
            $a = explode(' = ', $line);
            if (count($a) != 2) {
                throw new \Exception('Invalid input');
            }
            if ($a[0] == 'mask') {
                $mask = $a[1];
                // example 1 is too slow for part 2
                if (substr_count($mask, 'X') > 20) {
                    return [strval($ans1), '0'];
                }
                continue;
            }
            if (substr($a[0], 0, 4) != 'mem[') {
                throw new \Exception('Invalid input');
            }
            $loc = intval(substr($a[0], 4, -1));
            $value = intval($a[1]);
            $maskedLoc = 0;
            $floatingBits = [];
            for ($i = 0; $i < self::BIT_SIZE; ++$i) {
                match ($mask[$i]) {
                    '0' => $maskedLoc |= ($loc & (1 << (self::BIT_SIZE - 1 - $i))),
                    '1' => $maskedLoc |= (1 << (self::BIT_SIZE - 1 - $i)),
                    'X' => $floatingBits[] = self::BIT_SIZE - 1 - $i,
                    default => throw new \Exception('Invalid mask'),
                };
            }
            for ($floatMask = 0; $floatMask < (1 << count($floatingBits)); ++$floatMask) {
                $current = $floatMask;
                $floatedLoc = $maskedLoc;
                $idx = 0;
                while ($current > 0) {
                    if ($current & 1) {
                        $floatedLoc |= (1 << $floatingBits[$idx]);
                    }
                    $current >>= 1;
                    ++$idx;
                }
                $mem[$floatedLoc] = $value;
            }
        }
        $ans2 = array_sum($mem);
        return [strval($ans1), strval($ans2)];
    }
}

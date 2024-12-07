<?php

declare(strict_types=1);

namespace TBali\Aoc2024;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2024 Day 7: Bridge Repair.
 *
 * @see https://adventofcode.com/2024/day/7
 */
final class Aoc2024Day07 extends SolutionBase
{
    public const YEAR = 2024;
    public const DAY = 7;
    public const TITLE = 'Bridge Repair';
    public const SOLUTIONS = [3351424677624, 204976636995111];
    public const EXAMPLE_SOLUTIONS = [[3749, 11387]];

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
        $results = [];
        $operands = [];
        foreach ($input as $row) {
            $a = explode(' ', $row);
            if (count($a) < 3) {
                throw new \Exception('missing operands');
            }
            if ($a[0][-1] != ':') {
                throw new \Exception('result must be followed by a `:`');
            }
            $results[] = intval(substr($a[0], 0, -1));
            $operands[] = array_map(intval(...), array_slice($a, 1));
        }
        // ---------- Part 1
        $ans1 = 0;
        foreach ($results as $idx => $result) {
            $max = 1 << (count($operands[$idx]) - 1);
            for ($perm = 0; $perm < $max; ++$perm) {
                $calculation = $operands[$idx][0];
                for ($i = 0; $i < count($operands[$idx]) - 1; ++$i) {
                    $calculation = match (($perm >> $i) & 1) {
                        0 => $calculation * $operands[$idx][$i + 1],
                        1 => $calculation + $operands[$idx][$i + 1],
                    };
                    if ($calculation > $result) {
                        break;
                    }
                }
                if ($calculation == $result) {
                    $ans1 += $result;
                    break;
                }
            }
        }
        // ---------- Part 2
        $ans2 = 0;
        foreach ($results as $idx => $result) {
            $max = 3 ** (count($operands[$idx]) - 1);
            for ($perm = 0; $perm < $max; ++$perm) {
                $calculation = $operands[$idx][0];
                $remaining = $perm;
                for ($i = 0; $i < count($operands[$idx]) - 1; ++$i) {
                    $operand = $operands[$idx][$i + 1];
                    $calculation = match ($remaining % 3) {
                        0 => $calculation * $operand,
                        1 => $calculation + $operand,
                        2 => intval(strval($calculation) . strval($operand)),
                        default => throw new \Exception('impossible'),
                    };
                    if ($calculation > $result) {
                        break;
                    }
                    $remaining = intdiv($remaining, 3);
                }
                if ($calculation == $result) {
                    $ans2 += $result;
                    break;
                }
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}

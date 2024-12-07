<?php

declare(strict_types=1);

namespace TBali\Aoc2024;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2024 Day 3: Mull It Over.
 *
 * @see https://adventofcode.com/2024/day/3
 */
final class Aoc2024Day03 extends SolutionBase
{
    public const YEAR = 2024;
    public const DAY = 3;
    public const TITLE = 'Mull It Over';
    public const SOLUTIONS = [174561379, 106921067];
    public const EXAMPLE_SOLUTIONS = [[161, 0], [0, 48]];

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
        $is_enabled = true;
        foreach ($input as $row) {
            $dos = [];
            $start = 0;
            while ($start < strlen($row)) {
                $i = strpos($row, 'do()', $start);
                if ($i === false) {
                    break;
                }
                $dos[] = [$i, true];
                $start = $i + 1;
            }
            $donts = [];
            $start = 0;
            while ($start < strlen($row)) {
                $i = strpos($row, "don't()", $start);
                if ($i === false) {
                    break;
                }
                $donts[] = [$i, false];
                $start = $i + 1;
            }
            $commands = array_merge($dos, $donts);
            usort($commands, static fn (array $a, array $b): int => $a[0] <=> $b[0]);
            $start = 0;
            while ($start < strlen($row)) {
                $next_start = strpos($row, 'mul(', $start);
                if ($next_start === false) {
                    break;
                }
                $start = $next_start + 4;
                $comma = strpos($row, ',', $start + 1);
                if ($comma === false) {
                    break;
                }
                $close = strpos($row, ')', $comma + 2);
                if ($close === false) {
                    break;
                }
                $op1s = substr($row, $start, $comma - $start);
                if (!array_all(str_split($op1s), static fn ($x) => ctype_digit($x))) {
                    continue;
                }
                $op1 = intval($op1s);
                $op2s = substr($row, $comma + 1, $close - $comma - 1);
                if (!array_all(str_split($op2s), static fn ($x) => ctype_digit($x))) {
                    continue;
                }
                $op2 = intval($op2s);
                $ans1 += $op1 * $op2;
                $i = count($commands) - 1;
                while (($i >= 0) and ($commands[$i][0] >= $start)) {
                    --$i;
                }
                if ($i >= 0) {
                    $is_enabled = $commands[$i][1];
                }
                if ($is_enabled) {
                    $ans2 += $op1 * $op2;
                }
                $start = $close + 1;
            }
            if (count($commands) > 0) {
                $is_enabled = $commands[count($commands) - 1][1];
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}

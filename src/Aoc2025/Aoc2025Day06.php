<?php

declare(strict_types=1);

namespace TBali\Aoc2025;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2025 Day 6: Trash Compactor.
 *
 * @see https://adventofcode.com/2025/day/6
 */
final class Aoc2025Day06 extends SolutionBase
{
    public const YEAR = 2025;
    public const DAY = 6;
    public const TITLE = 'Trash Compactor';
    public const SOLUTIONS = [6378679666679, 11494432585168];
    public const EXAMPLE_SOLUTIONS = [[4277556, 3263827]];

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
        if (count($input) < 3) {
            throw new \Exception('Invalid input');
        }
        $operators = [];
        $positions = [];
        $after_op = false;
        $op_line = $input[count($input) - 1];
        for ($i = 0; $i < strlen($op_line); ++$i) {
            if ($op_line[$i] == ' ') {
                $after_op = false;
                continue;
            }
            if ($op_line[$i] == '+' || $op_line[$i] == '*') {
                if ($after_op) {
                    throw new \Exception('Invalid input');
                }
                $operators[] = $op_line[$i];
                $positions[] = $i;
                $after_op = true;
                continue;
            }
            throw new \Exception('Invalid input');
        }
        $max_y = max(array_map(strlen(...), $input));
        $positions[] = $max_y + 1;
        // ---------- Part 1
        $ans1 = 0;
        for ($i = 0; $i < count($operators); ++$i) {
            $partial = match ($operators[$i]) {
                '+' => 0,
                '*' => 1,
            };
            for ($y = 0; $y < count($input) - 1; ++$y) {
                $v = intval(trim(substr($input[$y], $positions[$i], $positions[$i + 1] - $positions[$i])));
                $partial = match ($operators[$i]) {
                    '+' => $partial + $v,
                    '*' => $partial * $v,
                };
            }
            $ans1 += $partial;
        }
        // ---------- Part 2
        $ans2 = 0;
        for ($i = 0; $i < count($operators); ++$i) {
            $partial = match ($operators[$i]) {
                '+' => 0,
                '*' => 1,
            };
            for ($x = $positions[$i]; $x < $positions[$i + 1] - 1; ++$x) {
                $v = 0;
                for ($y = 0; $y < count($input) - 1; ++$y) {
                    $c = $input[$y][$x] ?? ' ';
                    if ($c == ' ' && $v == 0) {
                        continue;
                    }
                    // @phpstan-ignore-next-line notIdentical.alwaysTrue
                    if ($c == ' ' && $v != 0) {
                        break;
                    }
                    $v = 10 * $v + intval($c);
                }
                $partial = match ($operators[$i]) {
                    '+' => $partial + $v,
                    '*' => $partial * $v,
                };
            }
            $ans2 += $partial;
        }
        return [strval($ans1), strval($ans2)];
    }
}

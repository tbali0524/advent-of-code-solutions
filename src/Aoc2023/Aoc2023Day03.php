<?php

declare(strict_types=1);

namespace TBali\Aoc2023;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2023 Day 3: Gear Ratios.
 *
 * Part 1: What is the sum of all of the part numbers in the engine schematic?
 * Part 2: What is the sum of all of the gear ratios in your engine schematic?
 *
 * @see https://adventofcode.com/2023/day/3
 */
final class Aoc2023Day03 extends SolutionBase
{
    public const YEAR = 2023;
    public const DAY = 3;
    public const TITLE = 'Gear Ratios';
    public const SOLUTIONS = [530849, 84900879];
    public const EXAMPLE_SOLUTIONS = [[4361, 467835]];

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
        $maxY = count($input);
        $maxX = strlen($input[0] ?? '');
        $ans1 = 0;
        $isInNumber = false;
        $isAdjacent = false;
        $adjacentGears = [];
        $gearNumbers = [];
        $number = 0;
        for ($y = 0; $y < $maxY; ++$y) {
            for ($x = 0; $x < $maxX; ++$x) {
                $c = $input[$y][$x];
                $isDigit = ($c >= '0') && ($c <= '9');
                if (!$isDigit and !$isInNumber) {
                    continue;
                }
                if ($isDigit) {
                    $isInNumber = true;
                    $number = $number * 10 + intval($c);
                    for ($dy = -1; $dy <= 1; ++$dy) {
                        for ($dx = -1; $dx <= 1; ++$dx) {
                            $nx = $x + $dx;
                            $ny = $y + $dy;
                            if (
                                ($nx < 0) or ($nx >= $maxX) or ($ny < 0) or ($ny >= $maxY)
                                or (($dx == 0) and ($dy == 0))
                            ) {
                                continue;
                            }
                            $nc = $input[$ny][$nx];
                            if (($nc != '.') and (($nc < '0') or ($nc > '9'))) {
                                $isAdjacent = true;
                                if ($nc == '*') {
                                    $adjacentGears[$ny . ' ' . $nx] = true;
                                }
                            }
                        }
                    }
                }
                if (!$isDigit or ($x == $maxX - 1)) {
                    if ($isAdjacent) {
                        $ans1 += $number;
                    }
                    foreach (array_keys($adjacentGears) as $hash) {
                        if (isset($gearNumbers[$hash])) {
                            $gearNumbers[$hash][] = $number;
                        } else {
                            $gearNumbers[$hash] = [$number];
                        }
                    }
                    $number = 0;
                    $isAdjacent = false;
                    $isInNumber = false;
                    $adjacentGears = [];
                }
            }
        }
        $ans2 = 0;
        foreach ($gearNumbers as $numbers) {
            if (count($numbers) == 2) {
                $ans2 += $numbers[0] * $numbers[1];
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}

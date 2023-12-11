<?php

declare(strict_types=1);

namespace TBali\Aoc2023;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2023 Day 11: Cosmic Expansion.
 *
 * Part 1: Find the length of the shortest path between every pair of galaxies. What is the sum of these lengths?
 * Part 2: What is the sum of these lengths?
 *
 * @see https://adventofcode.com/2023/day/11
 */
final class Aoc2023Day11 extends SolutionBase
{
    public const YEAR = 2023;
    public const DAY = 11;
    public const TITLE = 'Cosmic Expansion';
    public const SOLUTIONS = [9329143, 710674907809];
    public const EXAMPLE_SOLUTIONS = [[374, 8410]];

    private const EXPANSE_PART1 = 2;
    private const EXPANSE_EXAMPLE_PART2 = 100;
    private const EXPANSE_PART2 = 1_000_000;

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
        $maxY = count($input);
        $maxX = strlen($input[0] ?? '');
        $galaxies = [];
        $isEmptyCols = array_fill(0, $maxX, true) ?: [];
        $isEmptyRows = array_fill(0, $maxY, true) ?: [];
        for ($y = 0; $y < $maxY; ++$y) {
            for ($x = 0; $x < $maxX; ++$x) {
                if ($input[$y][$x] == '#') {
                    $galaxies[] = [$x, $y];
                    $isEmptyRows[$y] = false;
                    $isEmptyCols[$x] = false;
                }
            }
        }
        // ---------- Part 1 + 2
        $isExample = $maxY <= 10;
        $ans1 = 0;
        $ans2 = 0;
        for ($i = 0; $i < count($galaxies); ++$i) {
            for ($j = $i + 1; $j < count($galaxies); ++$j) {
                $x1 = intval(min($galaxies[$i][0], $galaxies[$j][0]));
                $x2 = intval(max($galaxies[$i][0], $galaxies[$j][0]));
                $y1 = intval(min($galaxies[$i][1], $galaxies[$j][1]));
                $y2 = intval(max($galaxies[$i][1], $galaxies[$j][1]));
                $ans1 += $x2 - $x1 + $y2 - $y1;
                $ans2 += $x2 - $x1 + $y2 - $y1;
                for ($x = $x1; $x <= $x2; ++$x) {
                    if ($isEmptyCols[$x]) {
                        $ans1 += self::EXPANSE_PART1 - 1;
                        $ans2 += ($isExample ? self::EXPANSE_EXAMPLE_PART2 : self::EXPANSE_PART2) - 1;
                    }
                }
                for ($y = $y1; $y <= $y2; ++$y) {
                    if ($isEmptyRows[$y]) {
                        $ans1 += self::EXPANSE_PART1 - 1;
                        $ans2 += ($isExample ? self::EXPANSE_EXAMPLE_PART2 : self::EXPANSE_PART2) - 1;
                    }
                }
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}

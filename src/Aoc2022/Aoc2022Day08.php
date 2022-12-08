<?php

declare(strict_types=1);

namespace TBali\Aoc2022;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2022 Day 8: Treetop Tree House.
 *
 * Part 1: Consider your map; how many trees are visible from outside the grid?
 * Part 2: Consider each tree on your map. What is the highest scenic score possible for any tree?
 *
 * @see https://adventofcode.com/2022/day/8
 */
final class Aoc2022Day08 extends SolutionBase
{
    public const YEAR = 2022;
    public const DAY = 8;
    public const TITLE = 'Treetop Tree House';
    public const SOLUTIONS = [1796, 288120];
    public const EXAMPLE_SOLUTIONS = [[21, 8], [0, 0]];

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
        $maxX = strlen($input[0] ?? '');
        $maxY = count($input);
        // ---------- Part 1
        $visible = [];
        for ($y = 0; $y < $maxY; ++$y) {
            $max = chr(ord('0') - 1);
            for ($x = 0; $x < $maxX; ++$x) {
                if ($input[$y][$x] > $max) {
                    $max = $input[$y][$x];
                    $visible[$y . ' ' . $x] = true;
                }
            }
            $max = chr(ord('0') - 1);
            for ($x = $maxX - 1; $x > 0; --$x) {
                if ($input[$y][$x] > $max) {
                    $max = $input[$y][$x];
                    $visible[$y . ' ' . $x] = true;
                }
            }
        }
        for ($x = 0; $x < $maxX; ++$x) {
            $max = chr(ord('0') - 1);
            for ($y = 0; $y < $maxY; ++$y) {
                if ($input[$y][$x] > $max) {
                    $max = $input[$y][$x];
                    $visible[$y . ' ' . $x] = true;
                }
            }
            $max = chr(ord('0') - 1);
            for ($y = $maxY - 1; $y >= 0; --$y) {
                if ($input[$y][$x] > $max) {
                    $max = $input[$y][$x];
                    $visible[$y . ' ' . $x] = true;
                }
            }
        }
        $ans1 = count($visible);
        // ---------- Part 2
        $ans2 = 0;
        for ($y = 0; $y < $maxY; ++$y) {
            for ($x = 0; $x < $maxX; ++$x) {
                $score = 1;
                foreach ([[1, 0], [0, 1], [-1, 0], [0, -1]] as [$dx, $dy]) {
                    $x1 = $x;
                    $y1 = $y;
                    $dirScore = 0;
                    while (true) {
                        $x1 += $dx;
                        $y1 += $dy;
                        if (($x1 < 0) or ($x1 >= $maxX) or ($y1 < 0) or ($y1 >= $maxY)) {
                            break;
                        }
                        ++$dirScore;
                        if ($input[$y1][$x1] >= $input[$y][$x]) {
                            break;
                        }
                    }
                    $score *= $dirScore;
                }
                $ans2 = max($ans2, $score);
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}

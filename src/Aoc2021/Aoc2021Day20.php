<?php

declare(strict_types=1);

namespace TBali\Aoc2021;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2021 Day 20: Trench Map.
 *
 * Part 1: How many pixels are lit in the resulting image?
 * Part 2: Start again with the original input image and apply the image enhancement algorithm 50 times.
 *         How many pixels are lit in the resulting image?
 *
 * Topics: Conway's Game of Life, simulation
 *
 * @see https://adventofcode.com/2021/day/20
 *
 * @codeCoverageIgnore
 */
final class Aoc2021Day20 extends SolutionBase
{
    public const YEAR = 2021;
    public const DAY = 20;
    public const TITLE = 'Trench Map';
    public const SOLUTIONS = [5268, 16875];
    public const EXAMPLE_SOLUTIONS = [[35, 3351]];

    private const MAX_STEPS_PART1 = 2;
    private const MAX_STEPS_PART2 = 50;

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
        if ((count($input) < 3) or ($input[1] != '')) {
            throw new \Exception('Invalid input');
        }
        $enhanceAlgo = $input[0];
        $minY = 0;
        $minX = 0;
        $maxX = strlen($input[2]);
        $maxY = count($input) - 2;
        $pixels = [];
        for ($y = 0; $y < $maxY; ++$y) {
            for ($x = 0; $x < $maxX; ++$x) {
                if (($input[2 + $y][$x] ?? '') == '#') {
                    $pixels[$y][$x] = true;
                }
            }
        }
        // ---------- Part 1 + 2
        $ans1 = 0;
        $backgroundLit = false;
        for ($step = 1; $step <= self::MAX_STEPS_PART2; ++$step) {
            --$minX;
            --$minY;
            ++$maxX;
            ++$maxY;
            $newPixels = [];
            $count = 0;
            for ($y = $minY; $y <= $maxY; ++$y) {
                for ($x = $minX; $x <= $maxX; ++$x) {
                    $key = 0;
                    for ($dy = -1; $dy <= 1; ++$dy) {
                        for ($dx = -1; $dx <= 1; ++$dx) {
                            $x1 = $x + $dx;
                            $y1 = $y + $dy;
                            if (($x1 <= $minX) or ($x1 >= $maxX) or ($y1 <= $minY) or ($y1 >= $maxY)) {
                                $lit = $backgroundLit;
                            } else {
                                $lit = isset($pixels[$y + $dy][$x + $dx]);
                            }
                            $key <<= 1;
                            if ($lit) {
                                $key |= 1;
                            }
                        }
                    }
                    if (($enhanceAlgo[$key] ?? '') == '#') {
                        $newPixels[$y][$x] = true;
                        ++$count;
                    }
                }
            }
            $backgroundLit = ($enhanceAlgo[$backgroundLit ? 0b111111111 : 0] == '#');
            $pixels = $newPixels;
            if ($step == self::MAX_STEPS_PART1) {
                $ans1 = $count;
            }
        }
        $ans2 = $count;
        return [strval($ans1), strval($ans2)];
    }
}

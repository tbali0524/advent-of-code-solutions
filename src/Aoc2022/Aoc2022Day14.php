<?php

declare(strict_types=1);

namespace TBali\Aoc2022;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2022 Day 14: Regolith Reservoir.
 *
 * Part 1: How many units of sand come to rest before sand starts flowing into the abyss below?
 * Part 2: Using your scan, simulate the falling sand until the source of the sand becomes blocked.
 *         How many units of sand come to rest?
 *
 * @see https://adventofcode.com/2022/day/14
 */
final class Aoc2022Day14 extends SolutionBase
{
    public const YEAR = 2022;
    public const DAY = 14;
    public const TITLE = 'Regolith Reservoir';
    public const SOLUTIONS = [828, 25500];
    public const EXAMPLE_SOLUTIONS = [[24, 93]];

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
        // ---------- Input partsing
        $walls = [];
        $maxY = 0;
        foreach ($input as $line) {
            $points = explode(' -> ', $line);
            [$prevX, $prevY] = array_map(intval(...), explode(',', $points[0]));
            for ($i = 1; $i < count($points); ++$i) {
                [$nextX, $nextY] = array_map(intval(...), explode(',', $points[$i]));
                if (($nextX == $prevX) and ($nextY > $prevY)) {
                    [$dx, $dy] = [0, 1];
                } elseif (($nextX == $prevX) and ($nextY < $prevY)) {
                    [$dx, $dy] = [0, -1];
                } elseif (($nextX > $prevX) and ($nextY == $prevY)) {
                    [$dx, $dy] = [1, 0];
                } elseif (($nextX < $prevX) and ($nextY == $prevY)) {
                    [$dx, $dy] = [-1, 0];
                } else {
                    throw new \Exception('Invalid input');
                }
                [$x, $y] = [$prevX, $prevY];
                $walls[$y][$x] = true;
                while (true) {
                    $x += $dx;
                    $y += $dy;
                    $walls[$y][$x] = true;
                    $maxY = max($maxY, $y);
                    if (($x == $nextX) and ($y == $nextY)) {
                        break;
                    }
                }
                [$prevX, $prevY] = [$nextX, $nextY];
            }
        }
        // ---------- Part 1
        $ans1 = 0;
        $sands = [];
        while (true) {
            [$x, $y] = [500, 0];
            while (true) {
                [$x1, $y1] = [$x, $y];
                $canFall = false;
                foreach ([[0, 1], [-1, 1], [1, 1]] as [$dx, $dy]) {
                    [$x1, $y1] = [$x + $dx, $y + $dy];
                    // @phpstan-ignore isset.offset, offsetAccess.nonOffsetAccessible
                    if (!isset($walls[$y1][$x1]) and !isset($sands[$y1][$x1])) {
                        $canFall = true;
                        break;
                    }
                }
                if (!$canFall) {
                    $sands[$y][$x] = true;
                    ++$ans1;
                    break;
                }
                [$x, $y] = [$x1, $y1];
                if ($y > $maxY) {
                    break 2;
                }
            }
        }
        // ---------- Part 2
        $ans2 = 0;
        $sands = [];
        while (true) {
            [$x, $y] = [500, 0];
            if (isset($sands[$y][$x])) {
                break;
            }
            while (true) {
                [$x1, $y1] = [$x, $y];
                $canFall = false;
                if ($y < $maxY + 1) {
                    foreach ([[0, 1], [-1, 1], [1, 1]] as [$dx, $dy]) {
                        [$x1, $y1] = [$x + $dx, $y + $dy];
                        if (!isset($walls[$y1][$x1]) and !isset($sands[$y1][$x1])) {
                            $canFall = true;
                            break;
                        }
                    }
                }
                if (!$canFall) {
                    $sands[$y][$x] = true;
                    ++$ans2;
                    break;
                }
                [$x, $y] = [$x1, $y1];
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}

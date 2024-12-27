<?php

declare(strict_types=1);

namespace TBali\Aoc2024;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2024 Day 20: Race Condition.
 *
 * @see https://adventofcode.com/2024/day/20
 */
final class Aoc2024Day20 extends SolutionBase
{
    public const YEAR = 2024;
    public const DAY = 20;
    public const TITLE = 'Race Condition';
    public const SOLUTIONS = [1450, 1015247];
    public const EXAMPLE_SOLUTIONS = [[10, 285]];

    public const DELTA_XY = [[-1, 0], [0, -1], [1, 0], [0, 1]];
    public const MAX_CHEAT_LEN_PART1 = 2;
    public const MAX_CHEAT_LEN_PART2 = 20;
    public const SAVING_THRESHOLD_PART1_EXAMPLE = 10;
    public const SAVING_THRESHOLD_PART2_EXAMPLE = 50;
    public const SAVING_THRESHOLD = 100;
    public const WALL = -2;
    public const UNEXPLORED = -1;

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
        $max_y = count($input);
        $max_x = strlen($input[0] ?? '');
        $grid = array_fill(0, $max_y, array_fill(0, $max_x, self::UNEXPLORED));
        $start_x = -1;
        $start_y = -1;
        $target_x = -1;
        $target_y = -1;
        for ($y = 0; $y < $max_y; ++$y) {
            if (strlen($input[$y]) != $max_x) {
                throw new \Exception('grid must be rectangular');
            }
            for ($x = 0; $x < $max_x; ++$x) {
                $c = $input[$y][$x];
                if ($c == '#') {
                    $grid[$y][$x] = self::WALL;
                } elseif ($c == 'S') {
                    $start_x = $x;
                    $start_y = $y;
                } elseif ($c == 'E') {
                    $target_x = $x;
                    $target_y = $y;
                } elseif ($c != '.') {
                    throw new \Exception('invalid character in grid');
                }
            }
        }
        if (($start_x < 0) or ($target_x < 0)) {
            throw new \Exception('missing start or target position in grid');
        }
        // ---------- Part 1 + 2
        // fill up grid with distances from target
        $x = $target_x;
        $y = $target_y;
        $dist = 0;
        while (true) {
            $grid[$y][$x] = $dist;
            if (($x == $start_x) and ($y == $start_y)) {
                break;
            }
            foreach (self::DELTA_XY as [$dx, $dy]) {
                $x1 = $x + $dx;
                $y1 = $y + $dy;
                if (($x1 < 0) or ($x1 >= $max_x) or ($y1 < 0) or ($y1 >= $max_y)) {
                    // @codeCoverageIgnoreStart
                    continue;
                    // @codeCoverageIgnoreEnd
                }
                if ($grid[$y1][$x1] == self::UNEXPLORED) {
                    $x = $x1;
                    $y = $y1;
                    break;
                }
            }
            ++$dist;
        }
        if ($max_y == 15) {
            $ans1 = self::solvePart($grid, self::MAX_CHEAT_LEN_PART1, self::SAVING_THRESHOLD_PART1_EXAMPLE);
            $ans2 = self::solvePart($grid, self::MAX_CHEAT_LEN_PART2, self::SAVING_THRESHOLD_PART2_EXAMPLE);
        } else {
            // @codeCoverageIgnoreStart
            $ans1 = self::solvePart($grid, self::MAX_CHEAT_LEN_PART1, self::SAVING_THRESHOLD);
            $ans2 = self::solvePart($grid, self::MAX_CHEAT_LEN_PART2, self::SAVING_THRESHOLD);
            // @codeCoverageIgnoreEnd
        }
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param array<int, array<int, int>> $grid
     */
    private function solvePart(array $grid, int $max_cheat_len, int $threshold): int
    {
        $max_y = count($grid);
        $max_x = count($grid[0] ?? []);
        $cheats = [];
        for ($y = 0; $y < $max_y; ++$y) {
            for ($x = 0; $x < $max_x; ++$x) {
                if ($grid[$y][$x] == self::WALL) {
                    continue;
                }
                foreach (self::DELTA_XY as [$dx, $dy]) {
                    $x1 = $x + $dx;
                    $y1 = $y + $dy;
                    if (($x1 < 0) or ($x1 >= $max_x) or ($y1 < 0) or ($y1 >= $max_y)) {
                        // @codeCoverageIgnoreStart
                        continue;
                        // @codeCoverageIgnoreEnd
                    }
                    for ($y2 = $y1 - ($max_cheat_len - 1); $y2 <= $y1 + $max_cheat_len - 1; ++$y2) {
                        if (($y2 < 0) or ($y2 >= $max_y)) {
                            continue;
                        }
                        $dx = $max_cheat_len - 1 - abs($y2 - $y1);
                        for ($x2 = $x1 - $dx; $x2 <= $x1 + $dx; ++$x2) {
                            if (($x2 < 0) or ($x2 >= $max_x)) {
                                continue;
                            }
                            if ($grid[$y2][$x2] == self::WALL) {
                                continue;
                            }
                            $cheat_len = abs($y2 - $y1) + abs($x2 - $x1) + 1;
                            $saving = $grid[$y][$x] - $grid[$y2][$x2] - $cheat_len;
                            if ($saving <= 0) {
                                continue;
                            }
                            $hash = $x | ($y << 16) | ($x2 << 32) | ($y2 << 48);
                            $cheats[$hash] = intval(max($cheats[$hash] ?? 0, $saving));
                        }
                    }
                }
            }
        }
        return count(array_filter($cheats, static fn (int $x): bool => $x >= $threshold));
    }
}

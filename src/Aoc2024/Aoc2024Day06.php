<?php

declare(strict_types=1);

namespace TBali\Aoc2024;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2024 Day 6: Guard Gallivant.
 *
 * @see https://adventofcode.com/2024/day/6
 */
final class Aoc2024Day06 extends SolutionBase
{
    public const YEAR = 2024;
    public const DAY = 6;
    public const TITLE = 'Guard Gallivant';
    public const SOLUTIONS = [4515, 1309];
    public const EXAMPLE_SOLUTIONS = [[41, 6]];

    public const EMPTY = '.';
    public const WALL = '#';
    public const START = '^';
    public const DELTA_XY = [[0, -1], [1, 0], [0, 1], [-1, 0]]; // must start with UP

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
        $max_x = strlen($input[0]);
        if (array_any(array_map(strlen(...), $input), static fn (int $x): bool => $x != $max_x)) {
            throw new \Exception('grid must be rectangular');
        }
        $start_x = 0;
        $start_y = 0;
        $has_start = false;
        for ($y = 0; $y < $max_y; ++$y) {
            for ($x = 0; $x < $max_x; ++$x) {
                if ($input[$y][$x] == self::START) {
                    $start_x = $x;
                    $start_y = $y;
                    $has_start = true;
                    continue;
                }
                if (($input[$y][$x] != self::EMPTY) and ($input[$y][$x] != self::WALL)) {
                    throw new \Exception('invalid character in grid');
                }
            }
        }
        if (!$has_start) {
            throw new \Exception('missing start position in grid');
        }
        // ---------- Part 1
        $sim_result = self::simGuard($start_x, $start_y, $input);
        if (count($sim_result) == 0) {
            throw new \Exception('input already contains loop');
        }
        $ans1 = count($sim_result);
        // ---------- Part 2
        $ans2 = 0;
        foreach ($sim_result as $pos) {
            $block_x = $pos & 0xFFFF;
            $block_y = ($pos >> 16) & 0xFFFF;
            if ($block_x == $start_x && $block_y == $start_y) {
                continue;
            }
            $input[$block_y][$block_x] = self::WALL;
            if (count(self::simGuard($start_x, $start_y, $input)) == 0) {
                ++$ans2;
            }
            $input[$block_y][$block_x] = self::EMPTY;
        }
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param array<int, string> $grid
     *
     * @return array<int, int>
     */
    public function simGuard(int $start_x, int $start_y, array $grid): array
    {
        $max_y = count($grid);
        $max_x = strlen($grid[0]);
        $x = $start_x;
        $y = $start_y;
        $dir = 0; // UP
        $visited_pos = [];
        $visited_pos_dir = [];
        while (true) {
            $visited_pos[$x | ($y << 16)] = true;
            $visited_pos_dir[$x | ($y << 16) | ($dir << 32)] = true;
            $x1 = $x;
            $y1 = $y;
            $turns = 0;
            for ($i = 0; $i < 4; ++$i) {
                [$dx, $dy] = self::DELTA_XY[$dir];
                $x1 = $x + $dx;
                $y1 = $y + $dy;
                if ($y1 < 0 || $y1 >= $max_y || $x1 < 0 || $x1 >= $max_x) {
                    break 2;
                }
                if ($grid[$y1][$x1] != self::WALL) {
                    break;
                }
                $dir = ($dir + 1) % 4;
                ++$turns;
            }
            $x = $x1;
            $y = $y1;
            if ($turns == 4 || isset($visited_pos_dir[$x | ($y << 16) | ($dir << 32)])) {
                return [];
            }
        }
        return array_keys($visited_pos);
    }
}

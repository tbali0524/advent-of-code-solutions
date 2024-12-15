<?php

declare(strict_types=1);

namespace TBali\Aoc2024;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2024 Day 15: Warehouse Woes.
 *
 * @see https://adventofcode.com/2024/day/15
 */
final class Aoc2024Day15 extends SolutionBase
{
    public const YEAR = 2024;
    public const DAY = 15;
    public const TITLE = 'Warehouse Woes';
    public const SOLUTIONS = [1383666, 1412866];
    public const EXAMPLE_SOLUTIONS = [[2028, 0], [10092, 9021], [0, 618]];

    public const EMPTY = '.';
    public const WALL = '#';
    public const START = '@';
    public const BOX = 'O';
    public const BOX_LEFT = '[';
    public const BOX_RIGHT = ']';

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
        $grid = [];
        $max_y = 0;
        $max_x = 0;
        $start_x = -1;
        $start_y = -1;
        $i = 0;
        while (($i < count($input)) and ($input[$i] != '')) {
            $grid[] = $input[$i];
            for ($x = 0; $x < strlen($input[$i]); ++$x) {
                if ($grid[$i][$x] == self::START) {
                    $start_x = $x;
                    $start_y = $i;
                    $grid[$i][$x] = '.';
                }
                if (!str_contains('.#O', $grid[$i][$x])) {
                    throw new \Exception('invalid character in grid');
                }
            }
            if ($i == 0) {
                $max_x = strlen($grid[0]);
            } elseif (strlen($grid[$i]) != $max_x) {
                throw new \Exception('grid must be rectangular');
            }
            ++$max_y;
            ++$i;
        }
        if ($start_y < 0) {
            throw new \Exception('missing start position in grid');
        }
        if ($i == count($input)) {
            throw new \Exception('instructions must be separated from the map by an empty line');
        }
        $instructions = [];
        while ($i < count($input)) {
            for ($j = 0; $j < strlen($input[$i]); ++$j) {
                $dxy = match ($input[$i][$j]) {
                    '>' => [1, 0],
                    'v' => [0, 1],
                    '<' => [-1, 0],
                    '^' => [0, -1],
                    default => throw new \Exception('invalid character in instruction'),
                };
                $instructions[] = $dxy;
            }
            ++$i;
        }
        // ---------- Part 1
        $start_grid = $grid;
        $x = $start_x;
        $y = $start_y;
        foreach ($instructions as [$dx, $dy]) {
            $is_ok = true;
            $x1 = $x;
            $y1 = $y;
            while (true) {
                $x1 += $dx;
                $y1 += $dy;
                if ($y1 < 0 || $y1 >= $max_y || $x1 < 0 || $x1 >= $max_x) {
                    // @codeCoverageIgnoreStart
                    $is_ok = false;
                    break;
                    // @codeCoverageIgnoreEnd
                }
                if ($grid[$y1][$x1] == self::EMPTY) {
                    break;
                }
                if ($grid[$y1][$x1] == self::WALL) {
                    $is_ok = false;
                    break;
                }
            }
            if (!$is_ok) {
                continue;
            }
            $x += $dx;
            $y += $dy;
            if (($y != $y1) or ($x != $x1)) {
                $grid[$y][$x] = self::EMPTY;
                $grid[$y1][$x1] = self::BOX;
            }
        }
        $ans1 = 0;
        for ($y = 0; $y < $max_y; ++$y) {
            for ($x = 0; $x < $max_x; ++$x) {
                if ($grid[$y][$x] == self::BOX) {
                    $ans1 += 100 * $y + $x;
                }
            }
        }
        // ---------- Part 2
        $grid = [];
        for ($y = 0; $y < $max_y; ++$y) {
            $grid[] = '';
            for ($x = 0; $x < $max_x; ++$x) {
                $grid[$y] .= match ($start_grid[$y][$x]) {
                    self::EMPTY => self::EMPTY . self::EMPTY,
                    self::BOX => self::BOX_LEFT . self::BOX_RIGHT,
                    self::WALL => self::WALL . self::WALL,
                    // @codeCoverageIgnoreStart
                    default => '',
                    // @codeCoverageIgnoreEnd
                };
            }
        }
        $start_x *= 2;
        $max_x *= 2;
        $x = $start_x;
        $y = $start_y;
        foreach ($instructions as [$dx, $dy]) {
            $x1 = $x + $dx;
            $y1 = $y + $dy;
            if ($y1 < 0 || $y1 >= $max_y || $x1 < 0 || $x1 >= $max_x) {
                // @codeCoverageIgnoreStart
                continue;
                // @codeCoverageIgnoreEnd
            }
            $moving_boxes = [];
            if ($grid[$y1][$x1] == self::WALL) {
                continue;
            }
            if ($grid[$y1][$x1] == self::EMPTY) {
                $x = $x1;
                $y = $y1;
                continue;
            }
            if ($grid[$y1][$x1] == self::BOX_LEFT) {
                $moving_boxes[] = [$x1, $y1];
            }
            if ($grid[$y1][$x1] == self::BOX_RIGHT) {
                $moving_boxes[] = [$x1 - 1, $y1];
            }
            $is_ok = true;
            $idx = 0;
            while ($idx < count($moving_boxes)) {
                [$xb, $yb] = $moving_boxes[$idx];
                ++$idx;
                $x1 = $xb + $dx;
                $y1 = $yb + $dy;
                if ($y1 < 0 || $y1 >= $max_y || $x1 < 0 || $x1 >= $max_x - 1) {
                    // @codeCoverageIgnoreStart
                    $is_ok = false;
                    break;
                    // @codeCoverageIgnoreEnd
                }
                $c1 = $grid[$y1][$x1];
                $c2 = $grid[$y1][$x1 + 1];
                if ($c1 == self::WALL || $c2 == self::WALL) {
                    $is_ok = false;
                    break;
                }
                if ($c1 == self::BOX_LEFT) {
                    $moving_boxes[] = [$x1, $y1];
                }
                if ($c1 == self::BOX_RIGHT && ($x1 != $xb + 1 || $y1 != $yb)) {
                    $moving_boxes[] = [$x1 - 1, $y1];
                }
                if ($c2 == self::BOX_LEFT && ($x1 + 1 != $xb || $y1 != $yb)) {
                    $moving_boxes[] = [$x1 + 1, $y1];
                }
            }
            if (!$is_ok) {
                continue;
            }
            foreach ($moving_boxes as [$xb, $yb]) {
                $grid[$yb][$xb] = self::EMPTY;
                $grid[$yb][$xb + 1] = self::EMPTY;
            }
            foreach ($moving_boxes as [$xb, $yb]) {
                $x1 = $xb + $dx;
                $y1 = $yb + $dy;
                $grid[$y1][$x1] = self::BOX_LEFT;
                $grid[$y1][$x1 + 1] = self::BOX_RIGHT;
            }
            $x += $dx;
            $y += $dy;
        }
        $ans2 = 0;
        for ($y = 0; $y < $max_y; ++$y) {
            for ($x = 0; $x < $max_x; ++$x) {
                if ($grid[$y][$x] == self::BOX_LEFT) {
                    $ans2 += 100 * $y + $x;
                }
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}

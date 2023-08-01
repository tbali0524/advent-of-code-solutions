<?php

declare(strict_types=1);

namespace TBali\Aoc2019;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2019 Day 20: Donut Maze.
 *
 * Part 1: In your maze, how many steps does it take to get from the open tile marked AA to the open tile marked ZZ?
 * Part 2: When accounting for recursion, how many steps does it take to get from the open tile marked AA
 *         to the open tile marked ZZ, both at the outermost layer?
 *
 * Topics: parsing, BFS
 *
 * @see https://adventofcode.com/2019/day/20
 */
final class Aoc2019Day20 extends SolutionBase
{
    public const YEAR = 2019;
    public const DAY = 20;
    public const TITLE = 'Donut Maze';
    public const SOLUTIONS = [454, 5744];
    public const EXAMPLE_SOLUTIONS = [[23, 0], [58, 0], [0, 396]];

    private const EMPTY = '.';

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
        $grid = $input;
        $maxY = count($input);
        $maxX = strlen($grid[2] ?? '');
        if ($grid[2][$maxX - 1] != ' ') {
            $maxX += 2;
        }
        $portals = [];
        $width = 0;
        while ($grid[2 + $width][2 + $width] != ' ') {
            ++$width;
        }
        $portals[] = [];
        // outer portals
        for ($y = 2; $y < $maxY - 2; ++$y) {
            $label = $grid[$y][0] . $grid[$y][1];
            if ($label == '  ') {
                continue;
            }
            $portals[0][$label] = [2, $y];
        }
        for ($y = 2; $y < $maxY - 2; ++$y) {
            $label = ($grid[$y][$maxX - 2] ?? ' ') . ($grid[$y][$maxX - 1] ?? ' ');
            if ($label == '  ') {
                continue;
            }
            $portals[0][$label] = [$maxX - 3, $y];
        }
        for ($x = 2; $x < $maxX - 2; ++$x) {
            $label = ($grid[0][$x] ?? ' ') . ($grid[1][$x] ?? ' ');
            if ($label == '  ') {
                continue;
            }
            $portals[0][$label] = [$x, 2];
        }
        for ($x = 2; $x < $maxX - 2; ++$x) {
            $label = ($grid[$maxY - 2][$x] ?? ' ') . ($grid[$maxY - 1][$x] ?? ' ');
            if ($label == '  ') {
                continue;
            }
            $portals[0][$label] = [$x, $maxY - 3];
        }
        // inner portals
        for ($y = 2 + $width; $y < $maxY - 2 - $width; ++$y) {
            $label = $grid[$y][$width + 2] . $grid[$y][$width + 3];
            if ($label == '  ') {
                continue;
            }
            $portals[1][$label] = [1 + $width, $y];
        }
        for ($y = 2 + $width; $y < $maxY - 2 - $width; ++$y) {
            $label = $grid[$y][$maxX - 4 - $width] . $grid[$y][$maxX - 3 - $width];
            if ($label == '  ') {
                continue;
            }
            $portals[1][$label] = [$maxX - 2 - $width, $y];
        }
        for ($x = 2 + $width; $x < $maxX - 2 - $width; ++$x) {
            $label = $grid[2 + $width][$x] . $grid[3 + $width][$x];
            if ($label == '  ') {
                continue;
            }
            $portals[1][$label] = [$x, 1 + $width];
        }
        for ($x = 2 + $width; $x < $maxX - 2 - $width; ++$x) {
            $label = $grid[$maxY - 4 - $width][$x] . $grid[$maxY - 3 - $width][$x];
            if ($label == '  ') {
                continue;
            }
            $portals[1][$label] = [$x, $maxY - 2 - $width];
        }
        $grid2Portal = [];
        for ($side = 0; $side < 2; ++$side) {
            foreach ($portals[$side] as $label => [$x, $y]) {
                $grid2Portal[$y][$x] = [$label, $side];
            }
        }
        [$startX, $startY] = $portals[0]['AA'];
        [$targetX, $targetY] = $portals[0]['ZZ'];
        // ---------- Part 1
        $ans1 = 0;
        $xy = $startX . ' ' . $startY;
        $visited = [$xy => true];
        $q = [[$startX, $startY, 0]];
        $readIdx = 0;
        while (true) {
            if ($readIdx >= count($q)) {
                // @codeCoverageIgnoreStart
                throw new \Exception('No solution found');
                // @codeCoverageIgnoreEnd
            }
            [$x, $y, $steps] = $q[$readIdx];
            ++$readIdx;
            if (($x == $targetX) and ($y == $targetY)) {
                $ans1 = $steps;
                break;
            }
            foreach ([[0, -1], [0, 1], [-1, 0], [1, 0]] as [$dx, $dy]) {
                $x1 = $x + $dx;
                $y1 = $y + $dy;
                if (($grid[$y1][$x1] ?? '') != self::EMPTY) {
                    continue;
                }
                $xy1 = $x1 . ' ' . $y1;
                if (isset($visited[$xy1])) {
                    continue;
                }
                $visited[$xy1] = true;
                $q[] = [$x1, $y1, $steps + 1];
            }
            if (!isset($grid2Portal[$y][$x])) {
                continue;
            }
            [$label, $side] = $grid2Portal[$y][$x];
            if (!isset($portals[1 - $side][$label])) {
                continue;
            }
            [$x1, $y1] = $portals[1 - $side][$label];
            $xy1 = $x1 . ' ' . $y1;
            if (isset($visited[$xy1])) {
                continue;
            }
            $visited[$xy1] = true;
            $q[] = [$x1, $y1, $steps + 1];
        }
        // ---------- Part 2
        if ($maxX < 40) {
            return [strval($ans1), '0'];
        }
        // ---------- Part 1
        $ans2 = 0;
        $level = 0;
        $xy = $startX . ' ' . $startY . ' ' . $level;
        $visited = [$xy => true];
        $q = [[$startX, $startY, $level, 0]];
        $readIdx = 0;
        while (true) {
            if ($readIdx >= count($q)) {
                // @codeCoverageIgnoreStart
                throw new \Exception('No solution found');
                // @codeCoverageIgnoreEnd
            }
            [$x, $y, $level, $steps] = $q[$readIdx];
            ++$readIdx;
            if (($x == $targetX) and ($y == $targetY) and ($level == 0)) {
                $ans2 = $steps;
                break;
            }
            foreach ([[0, -1], [0, 1], [-1, 0], [1, 0]] as [$dx, $dy]) {
                $x1 = $x + $dx;
                $y1 = $y + $dy;
                if (($grid[$y1][$x1] ?? '') != self::EMPTY) {
                    continue;
                }
                $xy1 = $x1 . ' ' . $y1 . ' ' . $level;
                if (isset($visited[$xy1])) {
                    continue;
                }
                $visited[$xy1] = true;
                $q[] = [$x1, $y1, $level, $steps + 1];
            }
            if (!isset($grid2Portal[$y][$x])) {
                continue;
            }
            [$label, $side] = $grid2Portal[$y][$x];
            if (!isset($portals[1 - $side][$label])) {
                continue;
            }
            [$x1, $y1] = $portals[1 - $side][$label];
            $level1 = $level + ($side == 0 ? -1 : 1);
            if ($level1 < 0) {
                continue;
            }
            $xy1 = $x1 . ' ' . $y1 . ' ' . $level1;
            if (isset($visited[$xy1])) {
                continue;
            }
            $visited[$xy1] = true;
            $q[] = [$x1, $y1, $level1, $steps + 1];
        }
        return [strval($ans1), strval($ans2)];
    }
}

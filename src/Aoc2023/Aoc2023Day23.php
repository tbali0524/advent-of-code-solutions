<?php

declare(strict_types=1);

namespace TBali\Aoc2023;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2023 Day 23: A Long Walk.
 *
 * Part 1: How many steps long is the longest hike?
 * Part 2: Find the longest hike you can take through the surprisingly dry hiking trails listed on your map.
 *         How many steps long is the longest hike?
 *
 * Topics: DFS, BFS, maze compression
 *
 * @see https://adventofcode.com/2023/day/23
 */
final class Aoc2023Day23 extends SolutionBase
{
    public const YEAR = 2023;
    public const DAY = 23;
    public const TITLE = 'A Long Walk';
    public const SOLUTIONS = [2106, 6350];
    public const EXAMPLE_SOLUTIONS = [[94, 154]];

    private const EMPTY = '.';
    private const WALL = '#';
    private const DELTA_XY = [
        '>' => [1, 0],
        'v' => [0, 1],
        '<' => [-1, 0],
        '^' => [0, -1],
    ];

    private int $maxX = 0;
    private int $maxY = 0;
    private int $startX = -1;
    private int $targetX = -1;
    /** @var array<int, string> */
    private array $grid = [];
    /** @var array<string, array{int, int}> */
    private array $crossroads = [];
    /** @var array<string, array<string, int>> */
    private array $distances = [];

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
        $this->grid = $input;
        $this->maxY = count($this->grid);
        $this->maxX = strlen($this->grid[0] ?? '');
        $this->startX = -1;
        $this->targetX = -1;
        for ($y = 0; $y < $this->maxY; ++$y) {
            for ($x = 0; $x < $this->maxX; ++$x) {
                $c = $this->grid[$y][$x];
                if (($c != self::EMPTY) and ($c != self::WALL) and !isset(self::DELTA_XY[$c])) {
                    throw new \Exception('Invalid input');
                }
                if (($y == 0) and ($c == self::EMPTY)) {
                    $this->startX = $x;
                }
                if (($y == $this->maxY - 1) and ($c == self::EMPTY)) {
                    $this->targetX = $x;
                }
            }
        }
        if (($this->startX < 0) or ($this->targetX < 0)) {
            throw new \Exception('Invalid input');
        }
        // ---------- Part 1
        $hash = $this->startX . ' 0';
        $path = [$hash => true];
        // @phpstan-ignore-next-line argument.type
        $ans1 = $this->dfs($this->startX, 0, $path) - 1;
        // ---------- Part 2
        $this->fillCrossroads();
        $this->fillDistances();
        // @phpstan-ignore-next-line argument.type
        $ans2 = $this->dfsCrossroads($this->startX, 0, $path);
        return [strval($ans1), strval($ans2)];
    }

    /**
     * Calculates the longest path to target using dfs. Too slow for part 2.
     *
     * @param array<string, bool> $path
     */
    private function dfs(int $x, int $y, array $path, bool $isSlippery = true): int
    {
        if (($y == $this->maxY - 1) and ($x == $this->targetX)) {
            return count($path);
        }
        $ans = 0;
        $c = $this->grid[$y][$x];
        foreach (self::DELTA_XY as $slope => [$dx, $dy]) {
            if ($isSlippery and isset(self::DELTA_XY[$c]) and ($slope != $c)) {
                continue;
            }
            $nextX = $x + $dx;
            $nextY = $y + $dy;
            if (($nextX < 0) or ($nextX >= $this->maxX) or ($nextY < 0) or ($nextY >= $this->maxY)) {
                continue;
            }
            if ($this->grid[$nextY][$nextX] == self::WALL) {
                continue;
            }
            $nextHash = $nextX . ' ' . $nextY;
            if (isset($path[$nextHash])) {
                continue;
            }
            $nextPath = $path;
            $nextPath[$nextHash] = true;
            $result = $this->dfs($nextX, $nextY, $nextPath, $isSlippery);
            if ($result > $ans) {
                $ans = $result;
            }
        }
        return $ans;
    }

    /**
     * Fills out $this->crossroads[] with crossroads plus the start and target positions.
     */
    private function fillCrossroads(): void
    {
        $this->crossroads = [];
        $x = $this->startX;
        $y = 0;
        $hash = $x . ' ' . $y;
        $this->crossroads[$hash] = [$x, $y];
        $x = $this->targetX;
        $y = $this->maxY - 1;
        $hash = $x . ' ' . $y;
        $this->crossroads[$hash] = [$x, $y];
        for ($y = 0; $y < $this->maxY; ++$y) {
            for ($x = 0; $x < $this->maxX; ++$x) {
                if ($this->grid[$y][$x] == self::WALL) {
                    continue;
                }
                $countNb = 0;
                foreach (self::DELTA_XY as [$dx, $dy]) {
                    $nextX = $x + $dx;
                    $nextY = $y + $dy;
                    if (($nextX < 0) or ($nextX >= $this->maxX) or ($nextY < 0) or ($nextY >= $this->maxY)) {
                        continue;
                    }
                    if ($this->grid[$nextY][$nextX] == self::WALL) {
                        continue;
                    }
                    ++$countNb;
                }
                if ($countNb > 2) {
                    $hash = $x . ' ' . $y;
                    $this->crossroads[$hash] = [$x, $y];
                }
            }
        }
    }

    /**
     * Fills out $this->distances[] with distances between neighbouring crossroads, using BFS.
     */
    private function fillDistances(): void
    {
        $this->distances = [];
        foreach ($this->crossroads as $startHash => [$startX, $startY]) {
            $visited = [$startHash => true];
            $q = [[$startX, $startY, 0]];
            $idxRead = 0;
            while (true) {
                if ($idxRead >= count($q)) {
                    break;
                }
                [$x, $y, $step] = $q[$idxRead];
                ++$idxRead;
                $hash = $x . ' ' . $y;
                if (($hash != $startHash) and isset($this->crossroads[$hash])) {
                    $this->distances[$startHash][$hash] = $step;
                    $this->distances[$hash][$startHash] = $step;
                    continue;
                }
                foreach (self::DELTA_XY as [$dx, $dy]) {
                    $nextX = $x + $dx;
                    $nextY = $y + $dy;
                    if (($nextX < 0) or ($nextX >= $this->maxX) or ($nextY < 0) or ($nextY >= $this->maxY)) {
                        continue;
                    }
                    if ($this->grid[$nextY][$nextX] == self::WALL) {
                        continue;
                    }
                    $nextHash = $nextX . ' ' . $nextY;
                    if (isset($visited[$nextHash])) {
                        continue;
                    }
                    $q[] = [$nextX, $nextY, $step + 1];
                    $visited[$nextHash] = true;
                }
            }
        }
    }

    /**
     * Calculates the longest path to target using dfs on crossroads.
     *
     * @param array<string, bool> $path
     */
    private function dfsCrossroads(int $x, int $y, array $path, int $countSteps = 0): int
    {
        if (($y == $this->maxY - 1) and ($x == $this->targetX)) {
            return $countSteps;
        }
        $ans = 0;
        $hash = $x . ' ' . $y;
        foreach (($this->distances[$hash] ?? []) as $nextHash => $distance) {
            if (isset($path[$nextHash])) {
                continue;
            }
            $nextPath = $path;
            $nextPath[$nextHash] = true;
            [$nextX, $nextY] = $this->crossroads[$nextHash];
            $result = $this->dfsCrossroads($nextX, $nextY, $nextPath, $countSteps + $distance);
            if ($result > $ans) {
                $ans = $result;
            }
        }
        return $ans;
    }
}

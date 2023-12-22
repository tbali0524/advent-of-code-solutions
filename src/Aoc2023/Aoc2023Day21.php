<?php

declare(strict_types=1);

namespace TBali\Aoc2023;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2023 Day 21: Step Counter.
 *
 * Part 1: How many garden plots could the Elf reach in exactly 64 steps?
 * Part 2: However, the step count the Elf needs is much larger!
 *         How many garden plots could the Elf reach in exactly ... steps?
 *
 * Topics: BFS
 *
 * @see https://adventofcode.com/2023/day/21
 */
final class Aoc2023Day21 extends SolutionBase
{
    public const YEAR = 2023;
    public const DAY = 21;
    public const TITLE = 'Step Counter';
    public const SOLUTIONS = [3820, 0]; // 632421652162077 fails
    public const EXAMPLE_SOLUTIONS = [[16, 0]]; // Part 2 solution is not valid for the example (different assumptions)

    private const DEBUG = false;
    private const DETAILED_DEBUG = false;
    private const MAX_STEPS_EXAMPLE_PART1 = 6;
    private const MAX_STEPS_PART1 = 64;
    private const MAX_STEPS_PART2 = 26501365;
    private const EMPTY = '.';
    private const WALL = '#';
    private const START = 'S';
    private const DELTA_XY = [[-1, 0], [0, 1], [1, 0], [0, -1]];

    private int $maxX = 0;
    private int $maxY = 0;
    private int $startX = -1;
    private int $startY = -1;
    /** @var array<int, string> */
    private array $grid = [];

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
        $this->startY = -1;
        for ($y = 0; $y < $this->maxY; ++$y) {
            for ($x = 0; $x < $this->maxX; ++$x) {
                $c = $this->grid[$y][$x];
                if ($c == self::START) {
                    $this->startX = $x;
                    $this->startY = $y;
                    $this->grid[$y][$x] = self::EMPTY;
                    continue;
                }
                if (($c != self::EMPTY) and ($c != self::WALL)) {
                    throw new \Exception('Invalid input');
                }
            }
        }
        if ($this->startX < 0) {
            throw new \Exception('Invalid input');
        }
        // ---------- Part 1
        $maxStep = $this->maxY < 12 ? self::MAX_STEPS_EXAMPLE_PART1 : self::MAX_STEPS_PART1;
        $ans1 = $this->solvePart1($this->startX, $this->startY, $maxStep);
        // ---------- Part 2
        $ans2 = 0;
        if ($this->maxY < 12) {
            return [strval($ans1), strval($ans2)];
        }
        // @codeCoverageIgnoreStart
        $maxStep = self::MAX_STEPS_PART2;
        // Solution works only with following assumptions (valid for input, but not for example):
        if (
            ($this->maxX != $this->maxY)
            or ($this->maxX % 2 != 1)
            or ($this->startX != $this->startY)
            or ($this->startX != intdiv($this->maxX, 2))
            or ($maxStep <= 2 * $this->maxX)
            or ($this->grid[0] != str_repeat(self::EMPTY, $this->maxX))
            or ($this->grid[$this->startY] != str_repeat(self::EMPTY, $this->maxX))
            or ($this->grid[$this->maxY - 1] != str_repeat(self::EMPTY, $this->maxX))
            // not checked here, but also the following columns must be also completely empty: 0, startX, maxX - 1
        ) {
            throw new \Exception('Invalid input');
        }
        $half = intdiv($this->maxX, 2);
        $n = intdiv($maxStep - $this->maxX - $half, $this->maxX);
        $remainingSteps = $maxStep - ($half + $n * $this->maxX + 1);
        foreach (self::DELTA_XY as [$dx, $dy]) {
            $ans2 += $this->solvePart1(
                $this->startX + $dx * $this->startX,
                $this->startY + $dy * $this->startY,
                $remainingSteps,
            );
        }
        $remainingSteps1 = $remainingSteps - ($half + 1);
        $remainingSteps2 = $remainingSteps1 + $this->maxX;
        foreach ([[0, 0], [0, 1], [1, 0], [1, 1]] as [$dx, $dy]) {
            $ans2 += $n * $this->solvePart1(
                $dx * ($this->maxX - 1),
                $dy * ($this->maxY - 1),
                $remainingSteps1,
            );
            $ans2 += ($n + 1) * $this->solvePart1(
                $dx * ($this->maxX - 1),
                $dy * ($this->maxY - 1),
                $remainingSteps2,
            );
        }
        $resultCenter = $this->solvePart1($this->startX, $this->startY, $this->maxX);
        $resultCheckerboard = $this->solvePart1($this->startX, $this->startY, $this->maxX - 1);
        if ($n % 2 == 1) {
            $countCenter = $n * $n;
        } else {
            $countCenter = ($n + 1) * ($n + 1);
        }
        $countCheckerboard = (2 * $n * $n) + (2 * $n) + 1 - $countCenter;
        $ans2 += $countCenter * $resultCenter + $countCheckerboard * $resultCheckerboard;
        return [strval($ans1), strval($ans2)];
        // @codeCoverageIgnoreEnd
    }

    /**
     * Counts reachable positions with exactly $maxSteps steps on a single grid starting at ($fromX, $fromY).
     */
    private function solvePart1(int $fromX, int $fromY, int $maxStep): int
    {
        $result = [];
        $hash = $fromX . ' ' . $fromY . ' ';
        $visited = [$hash => true];
        $q = [[$fromX, $fromY, 0]];
        $readIdx = 0;
        while (true) {
            if ($readIdx >= count($q)) {
                break;
            }
            [$x, $y, $step] = $q[$readIdx];
            ++$readIdx;
            if ($step % 2 == $maxStep % 2) {
                $result[$x . ' ' . $y] = true;
                if ($step == $maxStep) {
                    continue;
                }
            }
            foreach (self::DELTA_XY as [$dx, $dy]) {
                $nextX = $x + $dx;
                $nextY = $y + $dy;
                if (($nextX < 0) or ($nextX >= $this->maxX) or ($nextY < 0) or ($nextY >= $this->maxY)) {
                    continue;
                }
                if ($this->grid[$nextY][$nextX] != self::EMPTY) {
                    continue;
                }
                $hash = $nextX . ' ' . $nextY . ' ' . strval($step + 1);
                if (isset($visited[$hash])) {
                    continue;
                }
                $q[] = [$nextX, $nextY, $step + 1];
                $visited[$hash] = true;
            }
        }
        // @phpstan-ignore-next-line
        if (self::DEBUG) {
            // @codeCoverageIgnoreStart
            echo "---- grid: [{$this->maxX} x {$this->maxY}]: from ({$fromX}, {$fromY}), steps: {$maxStep}, result = "
                . count($result), PHP_EOL;
            // @phpstan-ignore-next-line
            if (self::DETAILED_DEBUG) {
                $resultGrid = $this->grid;
                foreach (array_keys($result) as $hash) {
                    [$x, $y] = explode(' ', $hash);
                    $resultGrid[intval($y)][intval($x)] = 'O';
                }
                for ($y = 0; $y < $this->maxY; ++$y) {
                    echo $resultGrid[$y], PHP_EOL;
                }
            }
            // @codeCoverageIgnoreEnd
        }
        return count($result);
    }
}

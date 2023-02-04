<?php

declare(strict_types=1);

namespace TBali\Aoc2018;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2018 Day 17: Reservoir Research.
 *
 * Part 1: How many tiles can the water reach within the range of y values in your scan?
 * Part 2: How many water tiles are left after the water spring stops producing water
 *         and all remaining water not at rest has drained?
 *
 * Topics: simulation
 *
 * @see https://adventofcode.com/2018/day/17
 */
final class Aoc2018Day17 extends SolutionBase
{
    public const YEAR = 2018;
    public const DAY = 17;
    public const TITLE = 'Reservoir Research';
    public const SOLUTIONS = [33052, 27068];
    public const EXAMPLE_SOLUTIONS = [[57, 29]];

    private const DEBUG = false;
    private const START_X = 500;

    private int $minY = 0;
    private int $maxY = 0;
    private int $minX = 0;
    private int $maxX = 0;
    /** @var array<int, array<int, bool>> */
    private array $walls = [];
    /** @var array<int, array<int, bool>> */
    private array $flows = [];
    /** @var array<int, array<int, bool>> */
    private array $waters = [];

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
        $this->parseInput($input);
        // ---------- Part 1 + 2
        $this->flows = [];
        $this->waters = [];
        $this->flow(self::START_X, $this->minY);
        $ans1 = array_sum(array_map(count(...), $this->flows));
        $ans2 = array_sum(array_map(count(...), $this->waters));
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param array<int, string> $input
     */
    private function parseInput(array $input): void
    {
        $this->walls = [];
        $this->minY = PHP_INT_MAX;
        $this->maxY = 0;
        $this->minX = PHP_INT_MAX;
        $this->maxX = 0;
        foreach ($input as $line) {
            if ($line[0] == 'x') {
                $count = sscanf($line, 'x=%d, y=%d..%d', $x, $fromY, $toY);
                /** @var int $x */
                /** @var int $fromY */
                /** @var int $toY */
                if ($count != 3) {
                    throw new \Exception('Invalid input');
                }
                for ($y = $fromY; $y <= $toY; ++$y) {
                    $this->walls[$y][$x] = true;
                }
                $this->minY = intval(min($this->minY, $fromY));
                $this->maxY = intval(max($this->maxY, $toY));
                $this->minX = intval(min($this->minX, $x));
                $this->maxX = intval(max($this->maxX, $x));
                continue;
            }
            if ($line[0] == 'y') {
                $count = sscanf($line, 'y=%d, x=%d..%d', $y, $fromX, $toX);
                /** @var int $y */
                /** @var int $fromX */
                /** @var int $toX */
                if ($count != 3) {
                    throw new \Exception('Invalid input');
                }
                for ($x = $fromX; $x <= $toX; ++$x) {
                    $this->walls[$y][$x] = true;
                }
                $this->minY = intval(min($this->minY, $y));
                $this->maxY = intval(max($this->maxY, $y));
                $this->minX = intval(min($this->minX, $fromX));
                $this->maxX = intval(max($this->maxX, $toX));
                continue;
            }
            throw new \Exception('Invalid input');
        }
    }

    private function flow(int $x, int $y): bool
    {
        if (($y < $this->minY) or ($y > $this->maxY)) {
            return false;
        }
        $this->flows[$y][$x] = true;
        // @phpstan-ignore-next-line
        if (self::DEBUG) {
            // @codeCoverageIgnoreStart
            echo '---- FLOW @' . $x . ',' . $y . PHP_EOL;
            $this->draw();
            // @codeCoverageIgnoreEnd
        }
        if (
            !isset($this->walls[$y + 1][$x])
            and !isset($this->flows[$y + 1][$x])
            and !isset($this->waters[$y + 1][$x])
        ) {
            $filledBelow = $this->flow($x, $y + 1);
        } elseif (isset($this->walls[$y + 1][$x]) or isset($this->waters[$y + 1][$x])) {
            $filledBelow = true;
        } else {
            $filledBelow = false;
        }
        if (!$filledBelow) {
            return false;
        }
        $canFill = true;
        for ($dx = -1; $dx <= 1; $dx += 2) {
            $x1 = $x + $dx;
            while (($x1 >= $this->minX - 1) and ($x1 <= $this->maxX + 1) and !isset($this->walls[$y][$x1])) {
                $this->flows[$y][$x1] = true;
                if (
                    !isset($this->walls[$y + 1][$x1])
                    and !isset($this->flows[$y + 1][$x1])
                    and !isset($this->waters[$y + 1][$x1])
                ) {
                    $filledBelow = $this->flow($x1, $y + 1);
                } elseif (isset($this->walls[$y + 1][$x1]) or isset($this->waters[$y + 1][$x1])) {
                    $filledBelow = true;
                } else {
                    $filledBelow = false;
                }
                if (!$filledBelow) {
                    break;
                }
                $x1 += $dx;
            }
            if (!$filledBelow) {
                $canFill = false;
            }
        }
        if (!$canFill) {
            // @phpstan-ignore-next-line
            if (self::DEBUG) {
                // @codeCoverageIgnoreStart
                echo '---- END FLOW @' . $x . ',' . $y . PHP_EOL;
                $this->draw();
                // @codeCoverageIgnoreEnd
            }
            return false;
        }
        $this->waters[$y][$x] = true;
        for ($dx = -1; $dx <= 1; $dx += 2) {
            $x1 = $x + $dx;
            while (($x1 >= $this->minX - 1) and ($x1 <= $this->maxX + 1) and !isset($this->walls[$y][$x1])) {
                $this->waters[$y][$x1] = true;
                $x1 += $dx;
            }
        }
        // @phpstan-ignore-next-line
        if (self::DEBUG) {
            // @codeCoverageIgnoreStart
            echo '---- END WATER @' . $x . ',' . $y . PHP_EOL;
            $this->draw();
            // @codeCoverageIgnoreEnd
        }
        return true;
    }

    /**
     * @codeCoverageIgnore
     */
    private function draw(): void
    {
        $grid = array_fill($this->minY, $this->maxY - $this->minY + 1, str_repeat('.', $this->maxX - $this->minX + 5));
        foreach ($this->walls as $y => $row) {
            foreach ($row as $x => $true) {
                $grid[$y][$x - $this->minX + 2] = '#';
            }
        }
        foreach ($this->flows as $y => $row) {
            foreach ($row as $x => $true) {
                $grid[$y][$x - $this->minX + 2] = '|';
            }
        }
        foreach ($this->waters as $y => $row) {
            foreach ($row as $x => $true) {
                $grid[$y][$x - $this->minX + 2] = '~';
            }
        }
        foreach ($grid as $line) {
            echo '  ' . $line, PHP_EOL;
        }
    }
}

/*
    private function flow(int $x, int $y, int $dirX = 0): bool
    {
        if (($y < $this->minY) or ($y > $this->maxY)) {
            return false;
        }
        echo '----- @' . $x . ',' . $y . ' (dir: ' . $dirX . ')' . PHP_EOL;
        $this->draw();
        $this->flows[$y][$x] = true;
        if (
            !isset($this->walls[$y + 1][$x])
            and !isset($this->flows[$y + 1][$x])
            and !isset($this->waters[$y + 1][$x])
        ) {
            $filledBelow = $this->flow($x, $y + 1, 0);
        } elseif (isset($this->walls[$y + 1][$x]) or isset($this->waters[$y + 1][$x])) {
            $filledBelow = true;
        } else {
            $filledBelow = false;
        }
        if (!$filledBelow) {
            return false;
        }
        if (
            !isset($this->walls[$y][$x - 1])
            and !isset($this->flows[$y][$x - 1])
            and !isset($this->waters[$y][$x - 1])
        ) {
            $filledLeft = $this->flow($x - 1, $y, -1);
        } elseif (isset($this->walls[$y][$x - 1]) or isset($this->waters[$y][$x - 1])) {
            $filledLeft = true;
        } else {
            $filledLeft = false;
        }
        if (
            !isset($this->walls[$y][$x + 1])
            and !isset($this->flows[$y][$x + 1])
            and !isset($this->waters[$y][$x + 1])
        ) {
            $filledRight = $this->flow($x + 1, $y, 1);
        } elseif (isset($this->walls[$y][$x + 1]) or isset($this->waters[$y][$x + 1])) {
            $filledRight = true;
        } else {
            $filledRight = false;
        }
        if (!$filledLeft or !$filledRight) {
            return false;
        }
        $this->waters[$y][$x] = true;
        $x1 = $x - 1;
        while (($x1 >= $this->minX - 1) and !isset($this->walls[$y][$x1])) {
            $this->waters[$y][$x1] = true;
            --$x1;
        }
        $x1 = $x + 1;
        while (($x1 <= $this->maxX + 1) and !isset($this->walls[$y][$x1])) {
            $this->waters[$y][$x1] = true;
            ++$x1;
        }
        return true;
    }
*/

<?php

declare(strict_types=1);

namespace TBali\Aoc2023;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2023 Day 14: Parabolic Reflector Dish.
 *
 * Part 1: Afterward, what is the total load on the north support beams?
 * Part 2: Run the spin cycle for 1000000000 cycles. Afterward, what is the total load on the north support beams?
 *
 * Topics: cycle detection
 *
 * @see https://adventofcode.com/2023/day/14
 */
final class Aoc2023Day14 extends SolutionBase
{
    public const YEAR = 2023;
    public const DAY = 14;
    public const TITLE = 'Parabolic Reflector Dish';
    public const SOLUTIONS = [112048, 105606];
    public const EXAMPLE_SOLUTIONS = [[136, 64]];

    private const int MAX_STEPS_PART2 = 1_000_000_000;

    private int $maxX = 0;
    private int $maxY = 0;
    /** @var array<int, string> */
    private array $grid = [];
    /** @var array<int, array<int, int>> */
    private array $fixRocksAtX = [];
    /** @var array<int, array<int, int>> */
    private array $fixRocksAtY = [];

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
        // ---------- Part 1
        $this->tiltNorth();
        $ans1 = $this->loadNorth();
        // ---------- Part 2
        $seenAt = [];
        for ($turn = 1; $turn <= self::MAX_STEPS_PART2; ++$turn) {
            $this->tiltNorth();
            $this->tiltWest();
            $this->tiltSouth();
            $this->tiltEast();
            $hash = implode('', $this->grid);
            if (!isset($seenAt[$hash])) {
                $seenAt[$hash] = $turn;
                continue;
            }
            $cycleLen = $turn - $seenAt[$hash];
            $cycleCount = intdiv(self::MAX_STEPS_PART2 - $turn, $cycleLen);
            $turn += $cycleCount * $cycleLen;
        }
        $ans2 = $this->loadNorth();
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param array<int, string> $input The lines of the input, without LF
     */
    private function parseInput(array $input): void
    {
        $this->grid = $input;
        $this->maxY = count($this->grid);
        $this->maxX = strlen($this->grid[0] ?? '');
        $this->fixRocksAtX = array_fill(0, $this->maxX, []) ?: throw new \Exception('Invalid input');
        $this->fixRocksAtY = array_fill(0, $this->maxY, []) ?: throw new \Exception('Invalid input');
        for ($y = 0; $y < $this->maxY; ++$y) {
            for ($x = 0; $x < $this->maxX; ++$x) {
                $c = $this->grid[$y][$x];
                if ($c == '#') {
                    // @phpstan-ignore assign.propertyType
                    $this->fixRocksAtX[$x][] = [$x, $y];
                    // @phpstan-ignore assign.propertyType
                    $this->fixRocksAtY[$y][] = [$x, $y];
                } elseif (($c != '.') and ($c != 'O')) {
                    throw new \Exception('Invalid input');
                }
            }
        }
    }

    private function loadNorth(): int
    {
        $ans = 0;
        for ($y = 0; $y < $this->maxY; ++$y) {
            for ($x = 0; $x < $this->maxX; ++$x) {
                if ($this->grid[$y][$x] == 'O') {
                    $ans += $this->maxY - $y;
                }
            }
        }
        return $ans;
    }

    private function tiltNorth(): void
    {
        for ($y = 0; $y < $this->maxY; ++$y) {
            for ($x = 0; $x < $this->maxX; ++$x) {
                if ($this->grid[$y][$x] != 'O') {
                    continue;
                }
                $this->grid[$y][$x] = '.';
                $newY = 0;
                foreach ($this->fixRocksAtX[$x] as [$x1, $y1]) {
                    if (($y1 < $y) and ($y1 >= $newY)) {
                        // @phpstan-ignore-next-line argument.type
                        $newY = intval($y1) + 1;
                    }
                }
                while ($this->grid[$newY][$x] == 'O') {
                    ++$newY;
                }
                $this->grid[$newY][$x] = 'O';
            }
        }
    }

    private function tiltWest(): void
    {
        for ($x = 0; $x < $this->maxX; ++$x) {
            for ($y = 0; $y < $this->maxY; ++$y) {
                if ($this->grid[$y][$x] != 'O') {
                    continue;
                }
                $this->grid[$y][$x] = '.';
                $newX = 0;
                foreach ($this->fixRocksAtY[$y] as [$x1, $y1]) {
                    if (($x1 < $x) and ($x1 >= $newX)) {
                        // @phpstan-ignore-next-line argument.type
                        $newX = intval($x1) + 1;
                    }
                }
                while ($this->grid[$y][$newX] == 'O') {
                    ++$newX;
                }
                $this->grid[$y][$newX] = 'O';
            }
        }
    }

    private function tiltSouth(): void
    {
        for ($y = $this->maxY - 1; $y >= 0; --$y) {
            for ($x = 0; $x < $this->maxX; ++$x) {
                if ($this->grid[$y][$x] != 'O') {
                    continue;
                }
                $this->grid[$y][$x] = '.';
                $newY = $this->maxY - 1;
                foreach ($this->fixRocksAtX[$x] as [$x1, $y1]) {
                    if (($y1 > $y) and ($y1 <= $newY)) {
                        // @phpstan-ignore-next-line argument.type
                        $newY = intval($y1) - 1;
                    }
                }
                while ($this->grid[$newY][$x] == 'O') {
                    --$newY;
                }
                $this->grid[$newY][$x] = 'O';
            }
        }
    }

    private function tiltEast(): void
    {
        for ($x = $this->maxX - 1; $x >= 0; --$x) {
            for ($y = 0; $y < $this->maxY; ++$y) {
                if ($this->grid[$y][$x] != 'O') {
                    continue;
                }
                $this->grid[$y][$x] = '.';
                $newX = $this->maxX - 1;
                foreach ($this->fixRocksAtY[$y] as [$x1, $y1]) {
                    if (($x1 > $x) and ($x1 <= $newX)) {
                        // @phpstan-ignore-next-line argument.type
                        $newX = intval($x1) - 1;
                    }
                }
                while ($this->grid[$y][$newX] == 'O') {
                    --$newX;
                }
                $this->grid[$y][$newX] = 'O';
            }
        }
    }
}

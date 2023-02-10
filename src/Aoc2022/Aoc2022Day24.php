<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2022;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2022 Day 24: Blizzard Basin.
 *
 * Part 1: What is the fewest number of minutes required to avoid the blizzards and reach the goal?
 * Part 2: What is the fewest number of minutes required to reach the goal, go back to the start,
 *         then reach the goal again?
 *
 * Topics: BFS
 *
 * @see https://adventofcode.com/2022/day/24
 */
final class Aoc2022Day24 extends SolutionBase
{
    public const YEAR = 2022;
    public const DAY = 24;
    public const TITLE = 'Blizzard Basin';
    public const SOLUTIONS = [297, 856];
    public const EXAMPLE_SOLUTIONS = [[10, 30], [18, 54]];

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
    /** @var array<int, string> */
    private array $grid = [];
    private int $startX = 0;
    private int $startY = 0;
    private int $targetX = 0;
    private int $targetY = 0;
    /** @var array<int, Blizzard> */
    private array $blizzards = [];
    private int $lcmCycles = 0;

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
        // ---------- Precalculate blizzard positions
        $this->lcmCycles = 1;
        foreach ($this->blizzards as $blizzard) {
            $this->lcmCycles = self::lcm($this->lcmCycles, $blizzard->cycle);
        }
        $hasBlizzard = [];
        for ($step = 0; $step < $this->lcmCycles; ++$step) {
            foreach ($this->blizzards as $blizzard) {
                [$dx, $dy] = self::DELTA_XY[$blizzard->dir] ?? [0, 0];
                $x = $blizzard->fromX + $dx * (($step + $blizzard->startPos) % $blizzard->cycle);
                $y = $blizzard->fromY + $dy * (($step + $blizzard->startPos) % $blizzard->cycle);
                $hash = $x | ($y << 16) | (($step % $this->lcmCycles) << 32);
                $hasBlizzard[$hash] = true;
            }
        }
        // ---------- Part 1 + 2
        $ans1 = -1;
        $ans2 = -1;
        $q = [[$this->startX, $this->startY, 0, 0]];
        $hash = $this->startX | ($this->startY << 16);
        $visited = [$hash => true];
        $readIdx = 0;
        while (true) {
            if ($readIdx >= count($q)) {
                // @codeCoverageIgnoreStart
                throw new \Exception('No solution found');
                // @codeCoverageIgnoreEnd
            }
            [$x, $y, $step, $phase] = $q[$readIdx];
            ++$readIdx;
            ++$step;
            foreach (self::DELTA_XY as [$dx, $dy]) {
                $x1 = $x + $dx;
                $y1 = $y + $dy;
                if (($x1 < 0) or ($x1 >= $this->maxX) or ($y1 < 0) or ($y1 >= $this->maxY)) {
                    continue;
                }
                if ($this->grid[$y1][$x1] == self::WALL) {
                    continue;
                }
                $phase1 = $phase;
                if (($phase == 1) and ($x1 == $this->startX) and ($y1 == $this->startY)) {
                    $phase1 = $phase + 1;
                } elseif (($phase != 1) and ($x1 == $this->targetX) and ($y1 == $this->targetY)) {
                    if ($ans1 < 0) {
                        $ans1 = $step;
                    }
                    if ($phase == 2) {
                        $ans2 = $step;
                        break 2;
                    }
                    $phase1 = $phase + 1;
                }
                $hash = $x1 | ($y1 << 16) | (($step % $this->lcmCycles) << 32);
                $hashPhased = $hash | ($phase1 << 48);
                if (isset($hasBlizzard[$hash]) or isset($visited[$hashPhased])) {
                    continue;
                }
                $q[] = [$x1, $y1, $step, $phase1];
                $visited[$hashPhased] = true;
            }
            // wait
            $phase1 = $phase;
            $hash = $x | ($y << 16) | (($step % $this->lcmCycles) << 32);
            $hashPhased = $hash | ($phase1 << 48);
            if (isset($hasBlizzard[$hash]) or isset($visited[$hashPhased])) {
                continue;
            }
            $q[] = [$x, $y, $step, $phase1];
            $visited[$hashPhased] = true;
        }
        return [strval($ans1), strval($ans2)];
    }

    /**
     * Parse input, sets grid, maxX, maxY, startX, startY, targetX, targetY, blizzards.
     *
     * @param array<int, string> $input The lines of the input, without LF
     */
    public function parseInput(array $input): void
    {
        $this->grid = $input;
        $this->maxY = count($input);
        $this->maxX = strlen($input[0] ?? '');
        if (($this->maxY == 0) or ($this->maxX == 0)) {
            // @codeCoverageIgnoreStart
            throw new \Exception('Invalid input');
            // @codeCoverageIgnoreEnd
        }
        $this->startY = 0;
        $this->targetY = $this->maxY - 1;
        $startX = strpos($this->grid[$this->startY], self::EMPTY);
        $targetX = strpos($this->grid[$this->targetY], self::EMPTY);
        if (($startX === false) or ($targetX === false)) {
            throw new \Exception('Invalid input');
        }
        $this->startX = $startX;
        $this->targetX = $targetX;
        $this->blizzards = [];
        foreach ($this->grid as $y => $row) {
            if (strlen($row) != $this->maxX) {
                // @codeCoverageIgnoreStart
                throw new \Exception('Invalid input');
                // @codeCoverageIgnoreEnd
            }
            for ($x = 0; $x < $this->maxX; ++$x) {
                $dir = $row[$x];
                if (($dir == self::WALL) or ($dir == self::EMPTY)) {
                    continue;
                }
                [$dx, $dy] = self::DELTA_XY[$dir] ?? throw new \Exception('Invalid input');
                $fromX = $x;
                $fromY = $y;
                $startPos = 0;
                while (true) {
                    $fromX -= $dx;
                    $fromY -= $dy;
                    if (($fromX < 0) or ($fromX >= $this->maxX) or ($fromY < 0) or ($fromY >= $this->maxY)) {
                        break;
                    }
                    if ($this->grid[$fromY][$fromX] == self::WALL) {
                        break;
                    }
                    ++$startPos;
                }
                $fromX += $dx;
                $fromY += $dy;
                $toX = $x;
                $toY = $y;
                $cycle = $startPos + 1;
                while (true) {
                    $toX += $dx;
                    $toY += $dy;
                    if (($toX < 0) or ($toX >= $this->maxX) or ($toY < 0) or ($toY >= $this->maxY)) {
                        break;
                    }
                    if ($this->grid[$toY][$toX] == self::WALL) {
                        break;
                    }
                    ++$cycle;
                }
                $this->blizzards[] = new Blizzard(
                    $dir,
                    $fromX,
                    $fromY,
                    $startPos,
                    $cycle,
                );
            }
        }
    }

    /**
     * Greatest common divisor.
     *
     * @see https://en.wikipedia.org/wiki/Greatest_common_divisor
     */
    private static function gcd(int $a, int $b): int
    {
        $a1 = max($a, $b);
        $b1 = min($a, $b);
        while ($b1 != 0) {
            $t = $b1;
            $b1 = $a1 % $b1;
            $a1 = $t;
        }
        return $a1;
    }

    /**
     * Least common multiple.
     *
     * @see https://en.wikipedia.org/wiki/Least_common_multiple
     */
    private static function lcm(int $a, int $b): int
    {
        return abs($a) * intdiv(abs($b), self::gcd($a, $b));
    }
}

// --------------------------------------------------------------------
final class Blizzard
{
    public function __construct(
        public readonly string $dir,
        public readonly int $fromX,
        public readonly int $fromY,
        public readonly int $startPos,
        public readonly int $cycle,
    ) {
    }
}

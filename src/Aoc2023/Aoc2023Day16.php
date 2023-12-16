<?php

declare(strict_types=1);

namespace TBali\Aoc2023;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2023 Day 16: The Floor Will Be Lava.
 *
 * Part 1: With the beam starting in the top-left heading right, how many tiles end up being energized?
 * Part 2: Find the initial beam configuration that energizes the largest number of tiles;
 *         how many tiles are energized in that configuration?
 *
 * Topics: BFS
 *
 * @see https://adventofcode.com/2023/day/16
 */
final class Aoc2023Day16 extends SolutionBase
{
    public const YEAR = 2023;
    public const DAY = 16;
    public const TITLE = 'The Floor Will Be Lava';
    public const SOLUTIONS = [7472, 7716];
    public const EXAMPLE_SOLUTIONS = [[46, 51]];

    private const DELTA_XY = [
        0 => [1, 0],    // east
        1 => [0, 1],    // south
        2 => [-1, 0],   // west
        3 => [0, -1],   // north
    ];
    private const NEXT_DIRECTION = [
        0 => [
            '.' => [0],
            '-' => [0],
            '|' => [1, 3],
            '/' => [3],
            '\\' => [1],
        ],
        1 => [
            '.' => [1],
            '-' => [0, 2],
            '|' => [1],
            '/' => [2],
            '\\' => [0],
        ],
        2 => [
            '.' => [2],
            '-' => [2],
            '|' => [1, 3],
            '/' => [1],
            '\\' => [3],
        ],
        3 => [
            '.' => [3],
            '-' => [0, 2],
            '|' => [3],
            '/' => [0],
            '\\' => [2],
        ],
    ];

    private int $maxX = 0;
    private int $maxY = 0;
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
        $this->grid = $input;
        $this->maxY = count($this->grid);
        $this->maxX = strlen($this->grid[0] ?? '');
        // ---------- Part 1
        $ans1 = $this->simBeam();
        // ---------- Part 2
        $startPositions = [];
        for ($x = 0; $x < $this->maxX; ++$x) {
            $startPositions[] = [$x, 0, 1];
            $startPositions[] = [$x, $this->maxY - 1, 3];
        }
        for ($y = 0; $y < $this->maxY; ++$y) {
            $startPositions[] = [0, $y, 0];
            $startPositions[] = [$this->maxX - 1, $y, 2];
        }
        $ans2 = 0;
        foreach ($startPositions as $startPosition) {
            $energy = $this->simBeam(...$startPosition);
            if ($energy > $ans2) {
                $ans2 = $energy;
            }
        }
        return [strval($ans1), strval($ans2)];
    }

    private function simBeam(int $startX = 0, int $startY = 0, int $startDir = 0): int
    {
        $energized = [];
        $hash = $startX . ' ' . $startY . ' ' . $startDir;
        $visited = [$hash => true];
        $q = [[$startX, $startY, $startDir]];
        $readIdx = 0;
        while (true) {
            if ($readIdx >= count($q)) {
                break;
            }
            [$x, $y, $dir] = $q[$readIdx];
            ++$readIdx;
            $c = $this->grid[$y][$x];
            if (!str_contains('.|-/\\', $c)) {
                throw new \Exception('Invalid input');
            }
            $energized[$x . ' ' . $y] = true;
            foreach (self::NEXT_DIRECTION[$dir][$c] as $nextDir) {
                [$dx, $dy] = self::DELTA_XY[$nextDir];
                $nextX = $x + $dx;
                $nextY = $y + $dy;
                if (($nextX < 0) or ($nextX >= $this->maxX) or ($nextY < 0) or ($nextY >= $this->maxY)) {
                    continue;
                }
                $hash = $nextX . ' ' . $nextY . ' ' . $nextDir;
                if (isset($visited[$hash])) {
                    continue;
                }
                $q[] = [$nextX, $nextY, $nextDir];
                $visited[$hash] = true;
            }
        }
        return count($energized);
    }
}

<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2018;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2018 Day 22: Mode Maze.
 *
 * Part 1: What is the total risk level for the smallest rectangle that includes 0,0 and the target's coordinates?
 * Part 2: What is the fewest number of minutes you can take to reach the target?
 *
 * Topics: pathfinding, A-Star (A*)
 *
 * @see https://adventofcode.com/2018/day/22
 */
final class Aoc2018Day22 extends SolutionBase
{
    public const YEAR = 2018;
    public const DAY = 22;
    public const TITLE = 'Mode Maze';
    public const SOLUTIONS = [7299, 1008];
    public const EXAMPLE_SOLUTIONS = [[114, 45]];

    private const EQUIP_COST = 7;
    private const CAN_MOVE = [
        0 => ['t' => true, 'c' => true, 'n' => false], // rock
        1 => ['t' => false, 'c' => true, 'n' => true], // wet
        2 => ['t' => true, 'c' => false, 'n' => true], // narrow
    ];
    private const EQUIPMENTS = ['t', 'c', 'n'];
    private const INFINITY = (PHP_INT_MAX >> 2); // to avoid ovwerflow with additions

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
        $count1 = sscanf($input[0], 'depth: %d', $depth);
        /** @var int $depth */
        $count2 = sscanf($input[1] ?? '', 'target: %d,%d', $targetX, $targetY);
        /** @var int $targetX */
        /** @var int $targetY */
        if (($count1 != 1) or ($count2 != 2)) {
            throw new \Exception('Invalid input');
        }
        $cave = new Cave($depth, $targetX, $targetY);
        // ---------- Part 1
        $ans1 = 0;
        for ($y = 0; $y <= $targetY; ++$y) {
            for ($x = 0; $x <= $targetX; ++$x) {
                $ans1 += $cave->getRegionType($x, $y);
            }
        }
        // ---------- Part 2
        // @see https://en.wikipedia.org/wiki/A*_search_algorithm
        $ans2 = 0;
        $openSet = new \SplPriorityQueue(); // max-heap, so priority must be set to -cost
        $startState = [0, 0, 't', 0];
        $hash = '0 0 t';
        $openSet->insert($startState, 0);
        $gScore = [$hash => 0];
        while (true) {
            if ($openSet->isEmpty()) {
                // @codeCoverageIgnoreStart
                throw new \Exception('No solution found');
                // @codeCoverageIgnoreEnd
            }
            $current = $openSet->extract();
            /** @phpstan-var array{int, int, string, int} $current */
            [$x, $y, $gear, $time] = $current;
            if (($x == $targetX) and ($y == $targetY) and ($gear == 't')) {
                $ans2 = $time;
                break;
            }
            $neighbors = [];
            foreach ([[1, 0], [0, 1], [-1, 0], [0, -1]] as [$dx, $dy]) {
                $x1 = $x + $dx;
                $y1 = $y + $dy;
                if (($x1 < 0) or ($y1 < 0)) {
                    continue;
                }
                $regionType = $cave->getRegionType($x1, $y1);
                if (!self::CAN_MOVE[$regionType][$gear]) {
                    continue;
                }
                $neighbors[] = [$x1, $y1, $gear, $time + 1, 1];
            }
            $regionType = $cave->getRegionType($x, $y);
            foreach (self::EQUIPMENTS as $gear1) {
                if ($gear1 == $gear) {
                    continue;
                }
                if (!self::CAN_MOVE[$regionType][$gear1]) {
                    continue;
                }
                $neighbors[] = [$x, $y, $gear1, $time + self::EQUIP_COST, self::EQUIP_COST];
            }
            $hash = $x . ' ' . $y . ' ' . $gear;
            foreach ($neighbors as [$x1, $y1, $gear1, $time1, $costStep]) {
                $tentativegScore = ($gScore[$hash] ?? self::INFINITY) + $costStep;
                $hash1 = $x1 . ' ' . $y1 . ' ' . $gear1;
                if ($tentativegScore >= ($gScore[$hash1] ?? self::INFINITY)) {
                    continue;
                }
                $gScore[$hash1] = $tentativegScore;
                $fScore = $tentativegScore + abs($targetX - $x1) + abs($targetY - $y1);
                $openSet->insert([$x1, $y1, $gear1, $time1], -$fScore);
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}

// --------------------------------------------------------------------
final class Cave
{
    public int $maxX = 0;
    public int $maxY = 0;
    /** @var array<int, array<int, int>> */
    private array $erosions = [];

    public function __construct(
        public readonly int $depth,
        public readonly int $targetX,
        public readonly int $targetY,
    ) {
        $this->setErosionRect(0, 0, $this->targetX + 1, $this->targetY + 1);
    }

    public function getRegionType(int $x, int $y): int
    {
        if (!isset($this->erosions[$y][$x])) {
            $this->setErosionRect($this->maxX, 0, $x + 1, $this->maxY);
            $this->setErosionRect(0, $this->maxY, $x + 1, $y + 1);
        }
        return $this->erosions[$y][$x] % 3;
    }

    /**
     * Calculates and sets the erosion for a rectangle area.
     *
     * Assumption: erosion left of and above the rectangle is already set
     */
    private function setErosionRect(int $fromX, int $fromY, int $toX, int $toY): void
    {
        if (($fromX < 0) or ($fromY < 0)) {
            // @codeCoverageIgnoreStart
            throw new \Exception('Impossible');
            // @codeCoverageIgnoreEnd
        }
        for ($y = $fromY; $y < $toY; ++$y) {
            for ($x = $fromX; $x < $toX; ++$x) {
                $this->setErosion($x, $y);
            }
        }
        $this->maxX = $toX;
        $this->maxY = $toY;
    }

    private function setErosion(int $x, int $y): void
    {
        if (($x == $this->targetX) and ($y == $this->targetY)) {
            $geologic = 0;
        } elseif ($y == 0) {
            $geologic = $x * 16807;
        } elseif ($x == 0) {
            $geologic = $y * 48271;
        } else {
            $geologic = $this->erosions[$y - 1][$x] * $this->erosions[$y][$x - 1];
        }
        $this->erosions[$y][$x] = ($geologic + $this->depth) % 20183;
    }
}

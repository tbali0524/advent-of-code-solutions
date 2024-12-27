<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2024;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2024 Day 16: Reindeer Maze.
 *
 * @see https://adventofcode.com/2024/day/16
 */
final class Aoc2024Day16 extends SolutionBase
{
    public const YEAR = 2024;
    public const DAY = 16;
    public const TITLE = 'Reindeer Maze';
    public const SOLUTIONS = [107468, 533];
    public const EXAMPLE_SOLUTIONS = [[7036, 45], [11048, 64]];

    public const EMPTY = '.';
    public const WALL = '#';
    public const START = 'S';
    public const TARGET = 'E';
    public const STRAIGHT_COST = 1;
    public const TURN_COST = 1000;
    public const DELTA_XY = [[1, 0], [0, -1], [-1, 0], [0, 1]]; // must start with East, and in circular order

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
        $grid = $input;
        $start_x = -1;
        $start_y = -1;
        $target_x = -1;
        $target_y = -1;
        if (array_any(array_map(strlen(...), $input), static fn (int $x): bool => $x != $max_x)) {
            throw new \Exception('grid must be rectangular');
        }
        for ($y = 0; $y < $max_y; ++$y) {
            for ($x = 0; $x < $max_x; ++$x) {
                if ($grid[$y][$x] == self::START) {
                    $start_x = $x;
                    $start_y = $y;
                } elseif ($grid[$y][$x] == self::TARGET) {
                    $target_x = $x;
                    $target_y = $y;
                } elseif (($grid[$y][$x] != self::WALL) and ($grid[$y][$x] != self::EMPTY)) {
                    throw new \Exception('invalid character in grid');
                }
            }
        }
        if (($start_x < 0) or ($target_x < 0)) {
            throw new \Exception('missing start or target position in grid');
        }
        // ---------- Part 1
        $ans1 = 0;
        $ans1 = 0;
        $pq = new MinPriorityQueue();
        $pq->setExtractFlags(\SplPriorityQueue::EXTR_BOTH);
        $best_costs = [];
        $on_best_path = [];
        $start_dir = 0; // east
        $hash = $start_x . ' ' . $start_y . ' ' . $start_dir;
        $path = [[$start_x, $start_y]];
        $item = [$start_x, $start_y, $start_dir, $path];
        $pq->insert($item, 0);
        $best_costs[$hash] = 0;
        while (!$pq->isEmpty()) {
            $pq_item = $pq->extract();
            /** @phpstan-var array{priority: int, data: array{int, int, int, array<int, array{int, int}>}} $pq_item */
            $item = $pq_item['data'];
            $total_cost = $pq_item['priority'];
            if (($ans1 != 0) and ($total_cost > $ans1)) {
                break;
            }
            [$x, $y, $dir, $path] = $item;
            $hash = $x . ' ' . $y . ' ' . $dir;
            if (($best_costs[$hash] ?? -1) != $total_cost) {
                continue;
            }
            if (($x == $target_x) and ($y == $target_y)) {
                $ans1 = $total_cost;
                foreach ($path as [$x, $y]) {
                    $on_best_path[$x . ' ' . $y] = true;
                }
                continue;
            }
            for ($next_dir = 0; $next_dir < 4; ++$next_dir) {
                if (abs($next_dir - $dir) == 2) {
                    // turning back
                    continue;
                }
                [$dx, $dy] = self::DELTA_XY[$next_dir];
                $next_x = $x + $dx;
                $next_y = $y + $dy;
                if ($next_x < 0 || $next_x >= $max_x || $next_y < 0 || $next_y >= $max_y) {
                    // @codeCoverageIgnoreStart
                    continue;
                    // @codeCoverageIgnoreEnd
                }
                if ($grid[$next_y][$next_x] == self::WALL) {
                    continue;
                }
                $next_cost = $total_cost + self::STRAIGHT_COST;
                if ($next_dir != $dir) {
                    $next_cost += self::TURN_COST;
                }
                $next_hash = $next_x . ' ' . $next_y . ' ' . $next_dir;
                if (($best_costs[$next_hash] ?? PHP_INT_MAX) < $next_cost) {
                    continue;
                }
                $next_path = $path;
                $next_path[] = [$next_x, $next_y];
                $next_item = [$next_x, $next_y, $next_dir, $next_path];
                $best_costs[$next_hash] = $next_cost;
                $pq->insert($next_item, $next_cost);
            }
        }
        $ans2 = count($on_best_path);
        return [strval($ans1), strval($ans2)];
    }
}

// --------------------------------------------------------------------
/**
 * @phpstan-extends \SplPriorityQueue<int, array{int, int, int, array<int, array{int, int}>}>
 */
final class MinPriorityQueue extends \SplPriorityQueue
{
    /**
     * @param int $a
     * @param int $b
     */
    public function compare($a, $b): int
    {
        return parent::compare($b, $a); // invert the order
    }
}

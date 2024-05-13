<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2023;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2023 Day 17: Clumsy Crucible.
 *
 * Part 1: What is the least heat loss it can incur?
 * Part 2: Directing the ultra crucible from the lava pool to the machine parts factory,
 *         what is the least heat loss it can incur?
 *
 * Topics: Dijkstra, priority queue
 *
 * @see https://adventofcode.com/2023/day/17
 */
final class Aoc2023Day17 extends SolutionBase
{
    public const YEAR = 2023;
    public const DAY = 17;
    public const TITLE = 'Clumsy Crucible';
    public const SOLUTIONS = [684, 822];
    public const EXAMPLE_SOLUTIONS = [[102, 94], [0, 71]];

    private const DEBUG = false;
    private const DELTA_XY = [
        0 => [1, 0],    // east
        1 => [0, 1],    // south
        2 => [-1, 0],   // west
        3 => [0, -1],   // north
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
        $ans1 = $this->solvePart(1);
        $ans2 = $this->solvePart(2);
        return [strval($ans1), strval($ans2)];
    }

    private function solvePart(int $part = 1): int
    {
        $ans = 0;
        $prevStates = [];
        $pq = new MinPriorityQueue();
        $pq->setExtractFlags(\SplPriorityQueue::EXTR_BOTH);
        // x, y, dir, straight-steps
        $pq->insert([0, 0, 0, 0], 0);
        $bestCosts = ['0 0 0 0' => 0];
        if ($part == 2) {
            $pq->insert([0, 0, 1, 0], 0);
            $bestCosts['0 0 1 0'] = 0;
        }
        while (!$pq->isEmpty()) {
            $item = $pq->extract();
            /** @phpstan-var array{priority: int, data: array{int, int, int, int}} $item */
            [$x, $y, $dir, $steps] = $item['data'];
            $totalCost = $item['priority'];
            $hash = $x . ' ' . $y . ' ' . $dir . ' ' . $steps;
            if (($bestCosts[$hash] ?? PHP_INT_MAX) != $totalCost) {
                // @codeCoverageIgnoreStart
                continue;
                // @codeCoverageIgnoreEnd
            }
            if (
                ($x == $this->maxX - 1) and ($y == $this->maxY - 1)
                and (($part == 1) or ($steps >= 4))
            ) {
                $ans = $totalCost;
                // @phpstan-ignore if.alwaysFalse,logicalAnd.leftAlwaysFalse
                if (self::DEBUG and ($part == 2)) {
                    // @codeCoverageIgnoreStart
                    echo '--- [' . $this->maxX . ' x ' . $this->maxY . '] Part #' . $part . ' : ' . $ans, PHP_EOL;
                    echo '[x y dir steps totalCost]', PHP_EOL;
                    echo $hash . ' ' . $totalCost, PHP_EOL;
                    while (isset($prevStates[$hash])) {
                        $hash = $prevStates[$hash];
                        echo $hash . ' ' . $bestCosts[$hash], PHP_EOL;
                    }
                    // @codeCoverageIgnoreEnd
                }
                break;
            }
            for ($nextDir = 0; $nextDir < 4; ++$nextDir) {
                if (abs($nextDir - $dir) == 2) {
                    // turning back
                    continue;
                }
                if ($nextDir == $dir) {
                    if ($steps >= ($part == 1 ? 3 : 10)) {
                        continue;
                    }
                    $nextSteps = $steps + 1;
                } else {
                    if (($part == 2) and ($steps < 4)) {
                        continue;
                    }
                    $nextSteps = 1;
                }
                [$dx, $dy] = self::DELTA_XY[$nextDir];
                $nextX = $x + $dx;
                $nextY = $y + $dy;
                if (($nextX < 0) or ($nextX >= $this->maxX) or ($nextY < 0) or ($nextY >= $this->maxY)) {
                    continue;
                }
                $nextCost = $totalCost + intval($this->grid[$nextY][$nextX]);
                $nextHash = $nextX . ' ' . $nextY . ' ' . $nextDir . ' ' . $nextSteps;
                if (($bestCosts[$nextHash] ?? PHP_INT_MAX) <= $nextCost) {
                    continue;
                }
                $bestCosts[$nextHash] = $nextCost;
                $prevStates[$nextHash] = $hash;
                $pq->insert([$nextX, $nextY, $nextDir, $nextSteps], $nextCost);
            }
        }
        return $ans;
    }
}

// --------------------------------------------------------------------
/**
 * @phpstan-extends \SplPriorityQueue<int, array{int, int, int, int}>
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

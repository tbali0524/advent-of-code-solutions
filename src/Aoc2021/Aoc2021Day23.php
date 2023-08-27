<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2021;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2021 Day 23: Amphipod.
 *
 * Part 1: What is the least energy required to organize the amphipods?
 * Part 2: Using the initial configuration from the full diagram,
 *         what is the least energy required to organize the amphipods?
 *
 * Topics: Dijkstra, priority queue
 *
 * @see https://adventofcode.com/2021/day/23
 *
 * @todo complete part 2
 *
 * @codeCoverageIgnore
 */
final class Aoc2021Day23 extends SolutionBase
{
    public const YEAR = 2021;
    public const DAY = 23;
    public const TITLE = 'Amphipod';
    public const SOLUTIONS = [10411, 0];
    public const EXAMPLE_SOLUTIONS = [[12521, 0]];

    private const DEBUG = false;

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
        // ---------- Part 1
        $burrow = new Burrow();
        $startState = Burrow::fromInput($input);
        $ans1 = $this->solvePart($burrow, $startState);
        // ---------- Part 2
        $ans2 = 0;
        $extendedInput = [
            $input[0],
            $input[1],
            $input[2],
            BurrowExtended::EXTRA_INPUT[0],
            BurrowExtended::EXTRA_INPUT[1],
            $input[3],
            $input[4],
        ];
        // [$startStateRoom, $startStateHallway] = BurrowExtended::fromInput($extendedInput);
        // $burrowPart2 = new BurrowExtended();
        // $ans2 = $this->solvePart($burrowPart2, $startStateRoom, $startStateHallway);
        return [strval($ans1), strval($ans2)];
    }

    public function solvePart(Burrow $burrow, int $startState): int
    {
        $ans = 0;
        $prevStates = [];
        $bestCosts = [$startState => 0];
        $costMoves = [$startState => 0];
        $pq = new MinPriorityQueue();
        $pq->setExtractFlags(\SplPriorityQueue::EXTR_BOTH);
        $pq->insert($startState, 0);
        while (!$pq->isEmpty()) {
            $item = $pq->extract();
            /** @phpstan-var array{priority: int, data: int} $item */
            $state = $item['data'];
            $totalCost = $item['priority'];
            if (($bestCosts[$state] ?? PHP_INT_MAX) != $totalCost) {
                continue;
            }
            if ($state == $burrow->targetState) {
                $ans = $totalCost;
                // @phpstan-ignore-next-line
                if (self::DEBUG) {
                    // @codeCoverageIgnoreStart
                    echo ' Total cost: ' . $ans, PHP_EOL;
                    $burrow->logState($state);
                    while (isset($prevStates[$state])) {
                        echo '------------------------ move cost: ' . $costMoves[$state], PHP_EOL;
                        $state = $prevStates[$state];
                        $burrow->logState($state);
                    }
                    // @codeCoverageIgnoreEnd
                }
                break;
            }
            $moves = $burrow->allMoves($state);
            foreach ($moves as [$newState, $costMove]) {
                $newCost = $totalCost + $costMove;
                if (($bestCosts[$newState] ?? PHP_INT_MAX) <= $newCost) {
                    continue;
                }
                $prevStates[$newState] = $state;
                $costMoves[$newState] = $costMove;
                $bestCosts[$newState] = $newCost;
                $pq->insert($newState, $newCost);
            }
        }
        return $ans;
    }
}

// --------------------------------------------------------------------
class Burrow
{
    // ids and xy positions of the occupiable cells:
    //   0123456789012
    // 0 #############
    // 1 #89.0.1.2.34#
    // 2 ###0#2#4#6###
    // 3   #1#3#5#7#
    // 4   #########
    public const INPUT_LINES = 5;
    public const MAX_CELLS = 15;
    public const MAX_ROOMS = 8;
    public const BITS_PER_CELL = 3;
    public const MASK_CELL = (1 << self::BITS_PER_CELL) - 1;
    public const CHAR_TO_AMPHIPOD = ['.' => 0, 'A' => 1, 'B' => 2, 'C' => 3, 'D' => 4];
    public const AMPHIPOD_TO_CHAR = '.ABCD';
    public const COSTS = [0, 1, 10, 100, 1000];
    public const HALLWAY_Y = 1;
    public const TARGET_INPUT = [
        '#############',
        '#...........#',
        '###A#B#C#D###',
        '  #A#B#C#D#',
        '  #########',
    ];
    public const ID2POS = [
        0 => [3, 2],
        1 => [3, 3],
        2 => [5, 2],
        3 => [5, 3],
        4 => [7, 2],
        5 => [7, 3],
        6 => [9, 2],
        7 => [9, 3],
        8 => [1, 1],
        9 => [2, 1],
        10 => [4, 1],
        11 => [6, 1],
        12 => [8, 1],
        13 => [10, 1],
        14 => [11, 1],
    ];

    /** @var array<int, array<int, int>> */
    public array $pos2id = [];
    /** @var array<int, array<int, int>> */
    public array $distances = [];
    /** @var array<int, array<int, int>> */
    public array $routeMasks = [];
    public int $targetState = 0;

    /**
     * Generates burrow geometry constants: pos2id, distances, routeMasks, targetState.
     */
    public function __construct()
    {
        foreach (self::ID2POS as $id => [$x, $y]) {
            $this->pos2id[$y][$x] = $id;
        }
        foreach (self::ID2POS as $fromId => [$fromX, $fromY]) {
            for ($toId = $fromId + 1; $toId < self::MAX_CELLS; ++$toId) {
                [$toX, $toY] = self::ID2POS[$toId];
                if (($fromY == self::HALLWAY_Y) and ($toY == self::HALLWAY_Y)) {
                    // hallway-to-hallway move not allowed
                    continue;
                }
                if ($fromX == $toX) {
                    // vertical-only move not allowed
                    continue;
                }
                $distance = 0;
                $minX = intval(min($fromX, $toX));
                $maxX = intval(max($fromX, $toX));
                $route = [];
                for ($y = self::HALLWAY_Y; $y <= $fromY - 1; ++$y) {
                    $route[] = [$fromX, $y];
                    ++$distance;
                }
                for ($x = $minX + 1; $x < $maxX; ++$x) {
                    $route[] = [$x, self::HALLWAY_Y];
                    ++$distance;
                }
                for ($y = self::HALLWAY_Y; $y <= $toY - 1; ++$y) {
                    $route[] = [$toX, $y];
                    ++$distance;
                }
                ++$distance;
                $this->distances[$fromId][$toId] = $distance;
                $this->distances[$toId][$fromId] = $distance;
                $routeMask = 0;
                foreach ($route as [$x, $y]) {
                    if (!isset($this->pos2id[$y][$x])) {
                        continue;
                    }
                    $id = $this->pos2id[$y][$x];
                    $routeMask |= self::MASK_CELL << ($id * self::BITS_PER_CELL);
                }
                $this->routeMasks[$fromId][$toId] = $routeMask;
                $this->routeMasks[$toId][$fromId] = $routeMask;
            }
        }
        $this->targetState = self::fromInput(self::TARGET_INPUT);
    }

    /**
     * Generates all possible moves from a given state.
     *
     * @phpstan-return array<int, array{int, int}> the list of moves: [state-after-move, energy-of-move]
     */
    public function allMoves(int $state): array
    {
        $moves = [];
        for ($id = 0; $id < self::MAX_CELLS; ++$id) {
            $amphipod = ($state >> ($id * self::BITS_PER_CELL)) & self::MASK_CELL;
            if ($amphipod == 0) {
                continue;
            }
            for ($toId = 0; $toId < self::MAX_CELLS; ++$toId) {
                if (!isset($this->distances[$id][$toId])) {
                    // move not allowed
                    continue;
                }
                $toCell = ($state >> ($toId * self::BITS_PER_CELL)) & self::MASK_CELL;
                if ($toCell != 0) {
                    // target cell is not empty
                    continue;
                }
                if (($state & $this->routeMasks[$id][$toId]) != 0) {
                    // there is another amphipod along the route
                    continue;
                }
                if ($toId < self::MAX_ROOMS) {
                    // check if move to room is allowed
                    $roomType = intdiv($toId, 2) + 1;
                    if ($roomType != $amphipod) {
                        continue;
                    }
                    $otherIdInRoom = $toId ^ 1;
                    $otherCellInRoom = ($state >> ($otherIdInRoom * self::BITS_PER_CELL)) & self::MASK_CELL;
                    if (($otherCellInRoom != 0) and ($otherCellInRoom != $amphipod)) {
                        continue;
                    }
                    if ((($toId & 1) == 0) and ($otherCellInRoom == 0)) {
                        continue;
                    }
                }
                $newState = $state & ~(self::MASK_CELL << ($id * self::BITS_PER_CELL));
                $newState |= $amphipod << ($toId * self::BITS_PER_CELL);
                $cost = $this->distances[$id][$toId] * self::COSTS[$amphipod];
                $moves[] = [$newState, $cost];
            }
        }
        return $moves;
    }

    /**
     * @codeCoverageIgnore
     */
    public function logState(int $state): void
    {
        $output = self::TARGET_INPUT;
        for ($id = 0; $id < self::MAX_CELLS; ++$id) {
            $amphipod = ($state >> ($id * self::BITS_PER_CELL)) & self::MASK_CELL;
            [$x, $y] = self::ID2POS[$id];
            $output[$y][$x] = self::AMPHIPOD_TO_CHAR[$amphipod] ?? '?';
        }
        foreach ($output as $line) {
            echo $line, PHP_EOL;
        }
    }

    /**
     * @param array<int, string> $lines the initial burrow as a list of 5 strings
     */
    public static function fromInput(array $lines): int
    {
        if (
            (count($lines) != self::INPUT_LINES)
            or ($lines[0] != '#############')
            or ($lines[1] != '#...........#')
            or (strlen($lines[2]) != 13)
            or ($lines[2][4] . $lines[2][6] . $lines[2][8] != '###')
            or (strlen($lines[3]) < 11)
            or ($lines[3][4] . $lines[3][6] . $lines[2][8] != '###')
            or ($lines[self::INPUT_LINES - 1] != '  #########')
        ) {
            throw new \Exception('Invalid input');
        }
        $state = 0;
        foreach (self::ID2POS as $id => [$x, $y]) {
            $amphipod = self::CHAR_TO_AMPHIPOD[$lines[$y][$x] ?? throw new \Exception('Invalid input')];
            $state |= $amphipod << ($id * self::BITS_PER_CELL);
        }
        return $state;
    }
}

// --------------------------------------------------------------------
class BurrowExtended extends Burrow
{
    // ids and xy positions of the occupiable cells:
    //   0123456789012
    // 0 #############
    // 1 #67.8.9.0.12#
    // 2 ###0#4#8#2###
    // 3   #1#5#9#3#
    // 4   #2#6#0#4#
    // 5   #3#7#1#5#
    // 4   #########
    public const INPUT_LINES = 7;
    public const MAX_CELLS = 23;
    public const MAX_ROOMS = 16;
    public const BITS_PER_CELL = 3;
    public const MASK_CELL = (1 << self::BITS_PER_CELL) - 1;
    public const TARGET_INPUT = [
        '#############',
        '#...........#',
        '###A#B#C#D###',
        '  #A#B#C#D#',
        '  #A#B#C#D#',
        '  #A#B#C#D#',
        '  #########',
    ];
    public const EXTRA_INPUT = [
        '  #D#C#B#A#',
        '  #D#B#A#C#',
    ];
    public const ID2POS = [
        0 => [3, 2],
        1 => [3, 3],
        2 => [3, 4],
        3 => [3, 5],
        4 => [5, 2],
        5 => [5, 3],
        6 => [5, 4],
        7 => [5, 5],
        8 => [7, 2],
        9 => [7, 3],
        10 => [7, 4],
        11 => [7, 5],
        12 => [9, 2],
        13 => [9, 3],
        14 => [9, 4],
        15 => [9, 5],
        16 => [1, 1],
        17 => [2, 1],
        18 => [4, 1],
        19 => [6, 1],
        20 => [8, 1],
        21 => [10, 1],
        22 => [11, 1],
    ];
}

// --------------------------------------------------------------------
/** @extends \SplPriorityQueue<int, int> */
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

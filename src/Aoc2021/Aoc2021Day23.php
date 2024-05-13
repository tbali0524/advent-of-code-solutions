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
 * @codeCoverageIgnore
 */
final class Aoc2021Day23 extends SolutionBase
{
    public const YEAR = 2021;
    public const DAY = 23;
    public const TITLE = 'Amphipod';
    public const SOLUTIONS = [10411, 46721];
    public const EXAMPLE_SOLUTIONS = [[12521, 44169]];

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
        [$startStateRoom, $startStateHallway] = Burrow::fromInput($input);
        $ans1 = $this->solvePart($burrow, $startStateRoom, $startStateHallway);
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
        [$startStateRoom, $startStateHallway] = BurrowExtended::fromInput($extendedInput);
        $burrowPart2 = new BurrowExtended();
        $ans2 = $this->solvePart($burrowPart2, $startStateRoom, $startStateHallway);
        return [strval($ans1), strval($ans2)];
    }

    public function solvePart(Burrow $burrow, int $startStateRoom, int $startStateHallway): int
    {
        $ans = 0;
        $prevStates = [];
        $bestCosts = [];
        $costMoves = [];
        $bestCosts[$startStateRoom][$startStateHallway] = 0;
        $costMoves[$startStateRoom][$startStateHallway] = 0;
        $pq = new MinPriorityQueue();
        $pq->setExtractFlags(\SplPriorityQueue::EXTR_BOTH);
        $pq->insert([$startStateRoom, $startStateHallway], 0);
        while (!$pq->isEmpty()) {
            $item = $pq->extract();
            /** @phpstan-var array{priority: int, data: array{int, int}} $item */
            [$stateRoom, $stateHallway] = $item['data'];
            $totalCost = $item['priority'];
            if (($bestCosts[$stateRoom][$stateHallway] ?? PHP_INT_MAX) != $totalCost) {
                continue;
            }
            if (($stateRoom == $burrow->targetStateRoom) and ($stateHallway == $burrow->targetStateHallway)) {
                $ans = $totalCost;
                // @phpstan-ignore if.alwaysFalse
                if (self::DEBUG) {
                    // @codeCoverageIgnoreStart
                    echo ' Total cost: ' . $ans, PHP_EOL;
                    $burrow->logState($stateRoom, $stateHallway);
                    while (isset($prevStates[$stateRoom][$stateHallway])) {
                        echo '------------------------ move cost: ' . $costMoves[$stateRoom][$stateHallway], PHP_EOL;
                        [$stateRoom, $stateHallway] = $prevStates[$stateRoom][$stateHallway];
                        $burrow->logState($stateRoom, $stateHallway);
                    }
                    // @codeCoverageIgnoreEnd
                }
                break;
            }
            $moves = $burrow->allMoves($stateRoom, $stateHallway);
            foreach ($moves as [$newStateRoom, $newStateHallway, $costMove]) {
                $newCost = $totalCost + $costMove;
                if (($bestCosts[$newStateRoom][$newStateHallway] ?? PHP_INT_MAX) <= $newCost) {
                    continue;
                }
                $prevStates[$newStateRoom][$newStateHallway] = [$stateRoom, $stateHallway];
                $costMoves[$newStateRoom][$newStateHallway] = $costMove;
                $bestCosts[$newStateRoom][$newStateHallway] = $newCost;
                $pq->insert([$newStateRoom, $newStateHallway], $newCost);
            }
        }
        return $ans;
    }
}

// --------------------------------------------------------------------
/**
 * @codeCoverageIgnore
 */
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
    /** @var array<int, string> */
    public const TARGET_INPUT = [
        '#############',
        '#...........#',
        '###A#B#C#D###',
        '  #A#B#C#D#',
        '  #########',
    ];
    /** @phpstan-var array<int, array{int, int}> */
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
    /** @phpstan-var array<int, array<int, int>> */
    public array $routeMaskRooms = [];
    /** @phpstan-var array<int, array<int, int>> */
    public array $routeMaskHallways = [];
    public int $targetStateRoom = 0;
    public int $targetStateHallway = 0;

    /**
     * Generates burrow geometry constants: pos2id, distances, routeMasks, targetState.
     */
    public function __construct()
    {
        foreach (static::ID2POS as $id => [$x, $y]) {
            $this->pos2id[$y][$x] = $id;
        }
        foreach (static::ID2POS as $fromId => [$fromX, $fromY]) {
            for ($toId = $fromId + 1; $toId < static::MAX_CELLS; ++$toId) {
                [$toX, $toY] = static::ID2POS[$toId];
                if (($fromY == static::HALLWAY_Y) and ($toY == static::HALLWAY_Y)) {
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
                for ($y = static::HALLWAY_Y; $y <= $fromY - 1; ++$y) {
                    $route[] = [$fromX, $y];
                    ++$distance;
                }
                for ($x = $minX + 1; $x < $maxX; ++$x) {
                    $route[] = [$x, static::HALLWAY_Y];
                    ++$distance;
                }
                for ($y = static::HALLWAY_Y; $y <= $toY - 1; ++$y) {
                    $route[] = [$toX, $y];
                    ++$distance;
                }
                ++$distance;
                $this->distances[$fromId][$toId] = $distance;
                $this->distances[$toId][$fromId] = $distance;
                $routeMaskRoom = 0;
                $routeMaskHallway = 0;
                foreach ($route as [$x, $y]) {
                    if (!isset($this->pos2id[$y][$x])) {
                        continue;
                    }
                    $id = $this->pos2id[$y][$x];
                    if ($id < static::MAX_ROOMS) {
                        $routeMaskRoom |= static::MASK_CELL << ($id * static::BITS_PER_CELL);
                    } else {
                        $routeMaskHallway |= static::MASK_CELL << (($id - static::MAX_ROOMS) * static::BITS_PER_CELL);
                    }
                }
                $this->routeMaskRooms[$fromId][$toId] = $routeMaskRoom;
                $this->routeMaskRooms[$toId][$fromId] = $routeMaskRoom;
                $this->routeMaskHallways[$fromId][$toId] = $routeMaskHallway;
                $this->routeMaskHallways[$toId][$fromId] = $routeMaskHallway;
            }
        }
        [$this->targetStateRoom, $this->targetStateHallway] = static::fromInput(static::TARGET_INPUT);
    }

    /**
     * Generates all possible moves from a given state.
     *
     * @phpstan-return array<int, array{int, int, int}> the list of moves: [stateRoom, stateHallway, costMove]
     */
    public function allMoves(int $stateRoom, int $stateHallway): array
    {
        $moves = [];
        for ($id = 0; $id < static::MAX_CELLS; ++$id) {
            if ($id < static::MAX_ROOMS) {
                $amphipod = ($stateRoom >> ($id * static::BITS_PER_CELL)) & static::MASK_CELL;
            } else {
                $amphipod = ($stateHallway >> (($id - static::MAX_ROOMS) * static::BITS_PER_CELL)) & static::MASK_CELL;
            }
            if ($amphipod == 0) {
                continue;
            }
            for ($toId = 0; $toId < static::MAX_CELLS; ++$toId) {
                if (!isset($this->distances[$id][$toId])) {
                    // move not allowed
                    continue;
                }
                if ($toId < static::MAX_ROOMS) {
                    $toCell = ($stateRoom >> ($toId * static::BITS_PER_CELL)) & static::MASK_CELL;
                } else {
                    $toCell = ($stateHallway >> (($toId - static::MAX_ROOMS) * static::BITS_PER_CELL))
                        & static::MASK_CELL;
                }
                if ($toCell != 0) {
                    // target cell is not empty
                    continue;
                }
                if (($stateRoom & $this->routeMaskRooms[$id][$toId]) != 0) {
                    // there is another amphipod along the route
                    continue;
                }
                if (($stateHallway & $this->routeMaskHallways[$id][$toId]) != 0) {
                    // there is another amphipod along the route
                    continue;
                }
                if ($toId < static::MAX_ROOMS) {
                    // check if move to room is allowed
                    $roomsPerType = intdiv(static::MAX_ROOMS, 4);
                    $roomType = intdiv($toId, $roomsPerType) + 1;
                    if ($roomType != $amphipod) {
                        continue;
                    }
                    $idxCellWithinType = $toId % $roomsPerType;
                    $isOk = true;
                    for ($i = $toId + 1; $i < $roomType * $roomsPerType; ++$i) {
                        $otherCellInRoom = ($stateRoom >> ($i * static::BITS_PER_CELL)) & static::MASK_CELL;
                        if ($otherCellInRoom != $amphipod) {
                            $isOk = false;
                            break;
                        }
                    }
                    if (!$isOk) {
                        continue;
                    }
                }
                if ($id < static::MAX_ROOMS) {
                    $newStateRoom = $stateRoom & ~(static::MASK_CELL << ($id * static::BITS_PER_CELL));
                    $newStateHallway = $stateHallway;
                } else {
                    $newStateRoom = $stateRoom;
                    $newStateHallway = $stateHallway & ~(static::MASK_CELL << (($id - static::MAX_ROOMS)
                        * static::BITS_PER_CELL));
                }
                if ($toId < static::MAX_ROOMS) {
                    $newStateRoom |= $amphipod << ($toId * static::BITS_PER_CELL);
                } else {
                    $newStateHallway |= $amphipod << (($toId - static::MAX_ROOMS) * static::BITS_PER_CELL);
                }
                $cost = $this->distances[$id][$toId] * static::COSTS[$amphipod];
                $moves[] = [$newStateRoom, $newStateHallway, $cost];
            }
        }
        return $moves;
    }

    /**
     * @codeCoverageIgnore
     */
    public function logState(int $stateRoom, int $stateHallway): void
    {
        $output = static::TARGET_INPUT;
        for ($id = 0; $id < static::MAX_CELLS; ++$id) {
            if ($id < static::MAX_ROOMS) {
                $amphipod = ($stateRoom >> ($id * static::BITS_PER_CELL)) & static::MASK_CELL;
            } else {
                $amphipod = ($stateHallway >> (($id - static::MAX_ROOMS) * static::BITS_PER_CELL)) & static::MASK_CELL;
            }
            [$x, $y] = static::ID2POS[$id];
            $output[$y][$x] = static::AMPHIPOD_TO_CHAR[$amphipod] ?? '?';
        }
        foreach ($output as $line) {
            echo $line, PHP_EOL;
        }
    }

    /**
     * @param array<int, string> $lines the initial burrow as a list of 5 strings
     *
     * @phpstan-return array{int, int}
     */
    public static function fromInput(array $lines): array
    {
        if (
            (count($lines) != static::INPUT_LINES)
            or ($lines[0] != '#############')
            or ($lines[1] != '#...........#')
            or (strlen($lines[2]) != 13)
            or ($lines[2][4] . $lines[2][6] . $lines[2][8] != '###')
            or (strlen($lines[3]) < 11)
            or ($lines[3][4] . $lines[3][6] . $lines[2][8] != '###')
            or ($lines[static::INPUT_LINES - 1] != '  #########')
        ) {
            throw new \Exception('Invalid input');
        }
        $stateRoom = 0;
        $stateHallway = 0;
        foreach (static::ID2POS as $id => [$x, $y]) {
            $amphipod = static::CHAR_TO_AMPHIPOD[$lines[$y][$x] ?? throw new \Exception('Invalid input')];
            if ($id < static::MAX_ROOMS) {
                $stateRoom |= $amphipod << ($id * static::BITS_PER_CELL);
            } else {
                $stateHallway |= $amphipod << (($id - static::MAX_ROOMS) * static::BITS_PER_CELL);
            }
        }
        return [$stateRoom, $stateHallway];
    }
}

// --------------------------------------------------------------------
/**
 * @codeCoverageIgnore
 */
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
    /** @var array<int, string> */
    public const TARGET_INPUT = [
        '#############',
        '#...........#',
        '###A#B#C#D###',
        '  #A#B#C#D#',
        '  #A#B#C#D#',
        '  #A#B#C#D#',
        '  #########',
    ];
    /** @var array<int, string> */
    public const EXTRA_INPUT = [
        '  #D#C#B#A#',
        '  #D#B#A#C#',
    ];
    /** @phpstan-var array<int, array{int, int}> */
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
/**
 * @phpstan-extends \SplPriorityQueue<int, array{int, int}>
 *
 * @codeCoverageIgnore
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

<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2019;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2019 Day 15: Oxygen System.
 *
 * Part 1: What is the fewest number of movement commands required to move the repair droid
 *         from its starting position to the location of the oxygen system?
 * Part 2: How many minutes will it take to fill with oxygen?
 *
 * Topics: assembly simulation, BFS
 *
 * @see https://adventofcode.com/2019/day/15
 *
 * @codeCoverageIgnore
 */
final class Aoc2019Day15 extends SolutionBase
{
    public const YEAR = 2019;
    public const DAY = 15;
    public const TITLE = 'Oxygen System';
    public const SOLUTIONS = [224, 284];

    private const SHOW_MAP = false;

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
        /** @var array<int, int> */
        $memory = array_map(intval(...), explode(',', $input[0]));
        // ---------- Part 1 + 2
        $robot = new DroidSimulator($memory);
        $map = new Map();
        $oxygenX = 0;
        $oxygenY = 0;
        $x = 0;
        $y = 0;
        $map->grid[$y][$x] = Map::EMPTY;
        while (true) {
            [$toX, $toY] = $map->closestUnknown($x, $y);
            if (($toX == $x) and ($toY == $y)) {
                break;
            }
            $moves = $map->getRoute($x, $y, $toX, $toY);
            foreach ($moves as $move) {
                $robot->inputs[] = $move;
                $robot->simulate();
                $response = $robot->outputs[count($robot->outputs) - 1];
                [$dx, $dy] = Map::DELTA_XY[$move];
                if ($response == 0) {
                    $map->grid[$y + $dy][$x + $dx] = Map::WALL;
                } else {
                    $x += $dx;
                    $y += $dy;
                    $map->grid[$y][$x] = Map::EMPTY;
                }
                if ($response == 2) {
                    $oxygenX = $x;
                    $oxygenY = $y;
                }
            }
        }
        // @phpstan-ignore-next-line
        if (self::SHOW_MAP) {
            // @codeCoverageIgnoreStart
            $map->printMap($oxygenX, $oxygenY);
            // @codeCoverageIgnoreEnd
        }
        $ans1 = count($map->getRoute($oxygenX, $oxygenY));
        $ans2 = $map->fillTime($oxygenX, $oxygenY);
        return [strval($ans1), strval($ans2)];
    }
}

// --------------------------------------------------------------------
/**
 * @codeCoverageIgnore
 */
final class Map
{
    public const WALL = '#';
    public const EMPTY = '.';
    public const UNKNOWN = ' ';
    public const DROID = 'D';
    public const DELTA_XY = [1 => [0, -1], 2 => [0, 1], 3 => [-1, 0], 4 => [1, 0]];

    /** @var array<int, array<int, string>> */
    public array $grid = [];

    /**
     * @return array<int, int>
     */
    public function getRoute(int $fromX, int $fromY, int $targetX = 0, int $targetY = 0): array
    {
        $xy = $fromX . ' ' . $fromY;
        $visited = [$xy => true];
        $q = [[$fromX, $fromY, []]];
        $readIdx = 0;
        while (true) {
            if ($readIdx >= count($q)) {
                return []; // no known path found
            }
            [$x, $y, $moves] = $q[$readIdx];
            ++$readIdx;
            if (($x == $targetX) and ($y == $targetY)) {
                return $moves;
            }
            $xy = $x . ' ' . $y;
            foreach (self::DELTA_XY as $move => [$dx, $dy]) {
                $x1 = $x + $dx;
                $y1 = $y + $dy;
                if (($this->grid[$y1][$x1] ?? self::UNKNOWN) != self::EMPTY) {
                    if (($x1 != $targetX) or ($y1 != $targetY)) {
                        continue;
                    }
                }
                $xy1 = $x1 . ' ' . $y1;
                if (isset($visited[$xy1])) {
                    continue;
                }
                $moves1 = $moves;
                $moves1[] = $move;
                $visited[$xy1] = true;
                $q[] = [$x1, $y1, $moves1];
            }
        }
    }

    /**
     * @phpstan-return array{int, int} The [x,y] position of the closest unknown cell to [fromX, fromY]
     */
    public function closestUnknown(int $fromX = 0, int $fromY = 0): array
    {
        $xy = $fromX . ' ' . $fromY;
        $visited = [$xy => true];
        $q = [[$fromX, $fromY]];
        $readIdx = 0;
        while (true) {
            if ($readIdx >= count($q)) {
                return [$fromX, $fromY]; // no unknown cell found
            }
            [$x, $y] = $q[$readIdx];
            ++$readIdx;
            $xy = $x . ' ' . $y;
            if (($this->grid[$y][$x] ?? self::UNKNOWN) == self::UNKNOWN) {
                return [$x, $y];
            }
            foreach (self::DELTA_XY as $move => [$dx, $dy]) {
                $x1 = $x + $dx;
                $y1 = $y + $dy;
                if (($this->grid[$y1][$x1] ?? self::UNKNOWN) == self::WALL) {
                    continue;
                }
                $xy1 = $x1 . ' ' . $y1;
                if (isset($visited[$xy1])) {
                    continue;
                }
                $visited[$xy1] = true;
                $q[] = [$x1, $y1];
            }
        }
    }

    public function fillTime(int $fromX, int $fromY): int
    {
        $xy = $fromX . ' ' . $fromY;
        $visited = [$xy => true];
        $q = [[$fromX, $fromY, 0]];
        $ans = 0;
        $readIdx = 0;
        while (true) {
            if ($readIdx >= count($q)) {
                return $ans;
            }
            [$x, $y, $time] = $q[$readIdx];
            if ($time > $ans) {
                $ans = $time;
            }
            ++$readIdx;
            $xy = $x . ' ' . $y;
            foreach (self::DELTA_XY as $move => [$dx, $dy]) {
                $x1 = $x + $dx;
                $y1 = $y + $dy;
                if (($this->grid[$y1][$x1] ?? self::WALL) == self::WALL) {
                    continue;
                }
                $xy1 = $x1 . ' ' . $y1;
                if (isset($visited[$xy1])) {
                    continue;
                }
                $visited[$xy1] = true;
                $q[] = [$x1, $y1, $time + 1];
            }
        }
    }

    /**
     * @codeCoverageIgnore
     */
    public function printMap(int $droidX, int $droidY): void
    {
        $minY = intval(min(array_keys($this->grid) ?: [0]));
        $maxY = intval(max(array_keys($this->grid) ?: [0]));
        $minX = intval(min(array_map(fn (array $a): int => intval(min(array_keys($a) ?: [0])), $this->grid) ?: [0]));
        $maxX = intval(max(array_map(fn (array $a): int => intval(max(array_keys($a) ?: [0])), $this->grid) ?: [0]));
        for ($y = $minY; $y <= $maxY; ++$y) {
            $s = '';
            for ($x = $minX; $x <= $maxX; ++$x) {
                if (($x == 0) and ($y == 0)) {
                    $s .= '0';
                } elseif (($x == $droidX) and ($y == $droidY)) {
                    $s .= Map::DROID;
                } else {
                    $s .= $this->grid[$y][$x] ?? self::UNKNOWN;
                }
            }
            echo $s, PHP_EOL;
        }
    }
}

// --------------------------------------------------------------------
/**
 * @codeCoverageIgnore
 */
final class DroidSimulator
{
    private const INSTRUCTION_LENGTHS =
        [1 => 4, 2 => 4, 3 => 2, 4 => 2, 5 => 3, 6 => 3, 7 => 4, 8 => 4, 9 => 2, 99 => 1];

    /** @var array<int, int> */
    public array $inputs = [];
    /** @var array<int, int> */
    public array $outputs = [];
    public bool $halted = false;

    private int $ic = 0;
    private int $idxInput = 0;
    private int $relBase = 0;

    /**
     * @param array<int, int> $memory
     */
    public function __construct(
        private array $memory,
    ) {
    }

    public function simulate(): void
    {
        while (true) {
            if ($this->ic >= count($this->memory)) {
                throw new \Exception('Invalid input');
            }
            $opcode = $this->memory[$this->ic] % 100;
            if ($opcode == 99) {
                $this->halted = true;
                return;
            }
            $len = self::INSTRUCTION_LENGTHS[$opcode] ?? throw new \Exception('Invalid input');
            if ($this->ic > count($this->memory) - $len) {
                throw new \Exception('Invalid input');
            }
            $addresses = [];
            $params = [];
            for ($i = 1; $i < $len; ++$i) {
                $mode = intdiv($this->memory[$this->ic], 10 ** ($i + 1)) % 10;
                $addresses[$i] = match ($mode) {
                    0 => $this->memory[$this->ic + $i],
                    1 => $this->ic + $i,
                    2 => $this->memory[$this->ic + $i] + $this->relBase,
                    default => throw new \Exception('Invalid input'),
                };
                $params[$i] = $this->memory[$addresses[$i]] ?? 0;
            }
            if (($opcode == 3) and ($this->idxInput >= count($this->inputs))) {
                return;
            }
            $oldIc = $this->ic;
            match ($opcode) {
                1 => $this->memory[$addresses[3]] = $params[1] + $params[2],
                2 => $this->memory[$addresses[3]] = $params[1] * $params[2],
                3 => $this->memory[$addresses[1]] = $this->inputs[$this->idxInput++],
                4 => $this->outputs[] = $params[1],
                5 => $this->ic = $params[1] != 0 ? $params[2] : $this->ic,
                6 => $this->ic = $params[1] == 0 ? $params[2] : $this->ic,
                7 => $this->memory[$addresses[3]] = $params[1] < $params[2] ? 1 : 0,
                8 => $this->memory[$addresses[3]] = $params[1] == $params[2] ? 1 : 0,
                9 => $this->relBase += $params[1],
                default => throw new \Exception('Invalid input'),
            };
            if ($this->ic == $oldIc) {
                $this->ic += $len;
            }
        }
    }
}

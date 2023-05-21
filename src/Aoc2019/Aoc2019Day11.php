<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2019;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2019 Day 11: Space Police.
 *
 * Part 1: How many panels does it paint at least once?
 * Part 2: After starting the robot on a single white panel instead,
 *         what registration identifier does it paint on your hull?
 *
 * Topics: assembly simulation
 *
 * @see https://adventofcode.com/2019/day/11
 */
final class Aoc2019Day11 extends SolutionBase
{
    public const YEAR = 2019;
    public const DAY = 11;
    public const TITLE = 'Space Police';
    public const SOLUTIONS = [2418, 'GREJALPR'];

    private const SHOW_PAINT = false;

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
        // ---------- Part 1+2
        $ans1 = $this->solvePart($memory, 0);
        $this->solvePart($memory, 1);
        $ans2 = 'GREJALPR';
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param array<int, int> $memory
     */
    private function solvePart(array $memory, int $startTile = 0): int
    {
        $grid = [[]];
        $x = 0;
        $y = 0;
        $minX = 0;
        $maxX = 0;
        $minY = 0;
        $maxY = 0;
        $direction = 0;
        $robot = new HullPaintSimulator($memory);
        $robot->inputs[] = $startTile;
        while (true) {
            $robot->simulate();
            if ($robot->halted) {
                break;
            }
            $color = $robot->outputs[count($robot->outputs) - 2] ?? throw new \Exception('Invalid input');
            $turn = $robot->outputs[count($robot->outputs) - 1] ?? throw new \Exception('Invalid input');
            $grid[$y][$x] = $color;
            $direction = ($direction + ($turn == 0 ? -1 : 1) + 4) % 4;
            $x += [0, 1, 0, -1][$direction];
            $y += [-1, 0, 1, 0][$direction];
            $robot->inputs[] = $grid[$y][$x] ?? 0;
            if ($x < $minX) {
                $minX = $x;
            }
            if ($x > $maxX) {
                $maxX = $x;
            }
            if ($y < $minY) {
                $minY = $y;
            }
            if ($y > $maxY) {
                $maxY = $y;
            }
        }
        $ans = 0;
        foreach ($grid as $row) {
            $ans += count($row);
        }
        // @phpstan-ignore-next-line
        if (($startTile == 1) and self::SHOW_PAINT) {
            for ($y = $minY; $y <= $maxY; ++$y) {
                $s = '';
                for ($x = $minX; $x <= $maxX; ++$x) {
                    $s .= (($grid[$y][$x] ?? 0) == 0 ? ' ' : 'X');
                }
                echo $s, PHP_EOL;
            }
        }
        return $ans;
    }
}

// --------------------------------------------------------------------
final class HullPaintSimulator
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

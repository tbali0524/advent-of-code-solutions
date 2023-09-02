<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2019;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2019 Day 13: Care Package.
 *
 * Part 1: How many block tiles are on the screen when the game exits?
 * Part 2: Beat the game by breaking all the blocks. What is your score after the last block is broken?
 *
 * Topics: assembly simulation, game simulation
 *
 * @see https://adventofcode.com/2019/day/13
 */
final class Aoc2019Day13 extends SolutionBase
{
    public const YEAR = 2019;
    public const DAY = 13;
    public const TITLE = 'Care Package';
    public const SOLUTIONS = [173, 8942];

    private const SHOW_ARCADE = false;

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
        // ---------- Part 1
        $ans1 = $this->solvePart1($memory);
        // ---------- Part 2
        $ans2 = $this->solvePart2($memory);
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param array<int, int> $memory
     */
    private function solvePart1(array $memory): int
    {
        $grid = [[]];
        $maxX = 0;
        $maxY = 0;
        $robot = new ArcadeSimulator($memory);
        $robot->simulate();
        for ($i = 0; $i < count($robot->outputs); $i += 3) {
            $x = $robot->outputs[$i];
            $y = $robot->outputs[$i + 1];
            $id = $robot->outputs[$i + 2];
            $grid[$y][$x] = $id;
            if ($x > $maxX) {
                $maxX = $x;
            }
            if ($y > $maxY) {
                $maxY = $y;
            }
        }
        $ans = 0;
        foreach ($grid as $row) {
            foreach ($row as $id) {
                if ($id == 2) {
                    ++$ans;
                }
            }
        }
        // @phpstan-ignore-next-line
        if (self::SHOW_ARCADE) {
            // @codeCoverageIgnoreStart
            for ($y = 0; $y <= $maxY; ++$y) {
                $s = '';
                for ($x = 0; $x <= $maxX; ++$x) {
                    $s .= ' X.-o'[$grid[$y][$x] ?? 0];
                }
                echo $s, PHP_EOL;
            }
            // @codeCoverageIgnoreEnd
        }
        return $ans;
    }

    /**
     * @param array<int, int> $memory
     */
    private function solvePart2(array $memory): int
    {
        $ans = 0;
        $memory[0] = 2;
        $robot = new ArcadeSimulator($memory);
        $startOutput = 0;
        $grid = [[]];
        $maxX = 0;
        $maxY = 0;
        $ballX = 0;
        $paddleX = 0;
        while (true) {
            $robot->inputs[] = ($ballX <=> $paddleX);
            $robot->simulate();
            for ($i = $startOutput; $i < count($robot->outputs); $i += 3) {
                $x = $robot->outputs[$i];
                $y = $robot->outputs[$i + 1];
                $id = $robot->outputs[$i + 2];
                if (($x == -1) and ($y == 0)) {
                    $ans = $id;
                    continue;
                }
                if ($id == 3) {
                    $paddleX = $x;
                }
                if ($id == 4) {
                    $ballX = $x;
                }
                $grid[$y][$x] = $id;
                if ($x > $maxX) {
                    $maxX = $x;
                }
                if ($y > $maxY) {
                    $maxY = $y;
                }
            }
            $startOutput = count($robot->outputs);
            // @phpstan-ignore-next-line
            if (self::SHOW_ARCADE) {
                // @codeCoverageIgnoreStart
                echo '-----------', PHP_EOL, PHP_EOL;
                for ($y = 0; $y <= $maxY; ++$y) {
                    $s = '';
                    for ($x = 0; $x <= $maxX; ++$x) {
                        $s .= ' X.-o'[$grid[$y][$x] ?? 0];
                    }
                    echo $s, PHP_EOL;
                }
                // @codeCoverageIgnoreEnd
            }
            if ($robot->halted) {
                break;
            }
        }
        return $ans;
    }
}

// --------------------------------------------------------------------
final class ArcadeSimulator
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

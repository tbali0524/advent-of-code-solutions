<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2019;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2019 Day 19: Tractor Beam.
 *
 * Part 1: How many points are affected by the tractor beam in the 50x50 area closest to the emitter?
 * Part 2: What value do you get if you take that point's X coordinate, multiply it by 10000,
 *         then add the point's Y coordinate?
 *
 * Topics: assembly simulation
 *
 * @see https://adventofcode.com/2019/day/19
 *
 * @codeCoverageIgnore
 */
final class Aoc2019Day19 extends SolutionBase
{
    public const YEAR = 2019;
    public const DAY = 19;
    public const TITLE = 'Tractor Beam';
    public const SOLUTIONS = [211, 8071006];

    private const MAX_GRID_PART1 = 50;
    private const SHIPS_SIZE_PART2 = 100;

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
        $ans1 = 0;
        for ($y = 0; $y < self::MAX_GRID_PART1; ++$y) {
            for ($x = 0; $x < self::MAX_GRID_PART1; ++$x) {
                $drone = new DroneSimulator($memory);
                $drone->inputs[] = $x;
                $drone->inputs[] = $y;
                $drone->simulate();
                $ans1 += $drone->outputs[count($drone->outputs) - 1];
            }
        }
        // ---------- Part 2
        $ans2 = 0;
        $prevStartY = 0;
        $endX = self::SHIPS_SIZE_PART2 - 1;
        while (true) {
            ++$endX;
            $endY = $prevStartY - 1;
            while (true) {
                ++$endY;
                if ($this->probe($memory, $endX, $endY)) {
                    break;
                }
            }
            $prevStartY = $endY;
            $isOk = true;
            for ($y = $endY + 1; $y < $endY + self::SHIPS_SIZE_PART2; ++$y) {
                if (!$this->probe($memory, $endX, $y)) {
                    $isOk = false;
                    break;
                }
            }
            if (!$isOk) {
                continue;
            }
            $endY = $prevStartY + self::SHIPS_SIZE_PART2 - 1;
            for ($x = $endX - 1; $x > $endX - self::SHIPS_SIZE_PART2; --$x) {
                if (!$this->probe($memory, $x, $endY)) {
                    $isOk = false;
                    break;
                }
            }
            if ($isOk) {
                $x = $endX - (self::SHIPS_SIZE_PART2 - 1);
                $y = $endY - (self::SHIPS_SIZE_PART2 - 1);
                $ans2 = 10_000 * $x + $y;
                break;
            }
        }
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param array<int, int> $memory
     */
    public function probe(array $memory, int $x, int $y): bool
    {
        $drone = new DroneSimulator($memory);
        $drone->inputs[] = $x;
        $drone->inputs[] = $y;
        $drone->simulate();
        return $drone->outputs[count($drone->outputs) - 1] == 1;
    }
}

// --------------------------------------------------------------------
/**
 * @codeCoverageIgnore
 */
final class DroneSimulator
{
    private const INSTRUCTION_LENGTHS
        = [1 => 4, 2 => 4, 3 => 2, 4 => 2, 5 => 3, 6 => 3, 7 => 4, 8 => 4, 9 => 2, 99 => 1];

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
                // @phpstan-ignore match.alwaysTrue
                9 => $this->relBase += $params[1],
                default => throw new \Exception('Invalid input'),
            };
            if ($this->ic == $oldIc) {
                $this->ic += $len;
            }
        }
    }
}

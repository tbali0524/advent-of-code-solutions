<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2019;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2019 Day 7: Amplification Circuit.
 *
 * Part 1: What is the highest signal that can be sent to the thrusters?
 * Part 2: Try every combination of the new phase settings on the amplifier feedback loop.
 *         What is the highest signal that can be sent to the thrusters?
 *
 * Topics: concurrent assembly simulation, permutations, Heap's algorithm
 *
 * @see https://adventofcode.com/2019/day/7
 */
final class Aoc2019Day07 extends SolutionBase
{
    public const YEAR = 2019;
    public const DAY = 7;
    public const TITLE = 'Amplification Circuit';
    public const SOLUTIONS = [255590, 58285150];
    // Note: example #2 expects 54321
    public const EXAMPLE_SOLUTIONS = [[43210, 0], [54312, 0], [65210, 0], [0, 139629729], [0, 18216]];

    private const MAX_AMPS = 5;

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
        $data = array_map(intval(...), explode(',', $input[0]));
        // ---------- Part 1 + 2
        $ans1 = 0;
        $ans2 = 0;
        // detect examples #4 and #5 that should skip part 1
        if (!in_array($data[1] ?? 0, [26, 52], true)) {
            $ans1 = $this->solvePart1($data);
        }
        // detect examples #1, #2, #3 that should skip part 2
        if (!in_array($data[1] ?? 0, [15, 23, 31], true)) {
            $ans2 = $this->solvePart2($data);
        }
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param array<int, int> $memory
     */
    private function solvePart1(array $memory): int
    {
        $best = 0;
        // Generating all permutations of 01234, @see https://en.wikipedia.org/wiki/Heap%27s_algorithm
        $a = range(0, self::MAX_AMPS - 1);
        $c = array_fill(0, self::MAX_AMPS, 0);
        $i = 1;
        while ($i < self::MAX_AMPS) {
            if ($c[$i] < $i) {
                if ($i % 2 == 0) {
                    $t = $a[0];
                    $a[0] = $a[$i];
                    $a[$i] = $t;
                } else {
                    $t = $a[$c[$i]];
                    $a[$c[$i]] = $a[$i];
                    $a[$i] = $t;
                }
                $output = 0;
                for ($j = 0; $j < self::MAX_AMPS; ++$j) {
                    $amplifier = new AmplifierSimulator($memory);
                    $amplifier->inputs[] = $a[$j];
                    $amplifier->inputs[] = $output;
                    $amplifier->simulate();
                    $output = $amplifier->outputs[count($amplifier->outputs) - 1];
                }
                if ($output > $best) {
                    $best = $output;
                }
                ++$c[$i];
                $i = 1;
                continue;
            }
            $c[$i] = 0;
            ++$i;
        }
        return $best;
    }

    /**
     * @param array<int, int> $memory
     */
    private function solvePart2(array $memory): int
    {
        $best = 0;
        // Generating all permutations of 56789
        $a = range(5, 5 + self::MAX_AMPS - 1);
        $c = array_fill(0, self::MAX_AMPS, 0);
        $i = 1;
        while ($i < self::MAX_AMPS) {
            if ($c[$i] < $i) {
                if ($i % 2 == 0) {
                    $t = $a[0];
                    $a[0] = $a[$i];
                    $a[$i] = $t;
                } else {
                    $t = $a[$c[$i]];
                    $a[$c[$i]] = $a[$i];
                    $a[$i] = $t;
                }
                $amplifiers = [];
                for ($j = 0; $j < self::MAX_AMPS; ++$j) {
                    $amplifier = new AmplifierSimulator($memory);
                    $amplifier->inputs[] = $a[$j];
                    $amplifiers[] = $amplifier;
                }
                $output = 0;
                while (true) {
                    for ($j = 0; $j < self::MAX_AMPS; ++$j) {
                        $amplifiers[$j]->inputs[] = $output;
                        $amplifiers[$j]->simulate();
                        $output = $amplifiers[$j]->outputs[count($amplifiers[$j]->outputs) - 1];
                    }
                    if ($amplifiers[self::MAX_AMPS - 1]->halted) {
                        break;
                    }
                }
                if ($output > $best) {
                    $best = $output;
                }
                ++$c[$i];
                $i = 1;
                continue;
            }
            $c[$i] = 0;
            ++$i;
        }
        return $best;
    }
}

// --------------------------------------------------------------------
final class AmplifierSimulator
{
    private const INSTRUCTION_LENGTHS = [1 => 4, 2 => 4, 3 => 2, 4 => 2, 5 => 3, 6 => 3, 7 => 4, 8 => 4, 99 => 1];

    /** @var array<int, int> */
    public array $inputs = [];
    /** @var array<int, int> */
    public array $outputs = [];
    public bool $halted = false;

    private int $ic = 0;
    private int $idxInput = 0;

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
            $params = [];
            for ($i = 1; $i < $len; ++$i) {
                $mode = intdiv($this->memory[$this->ic], 10 ** ($i + 1)) % 10;
                $params[$i] = match ($mode) {
                    0 => $this->memory[$this->memory[$this->ic + $i]] ?? throw new \Exception('Invalid input'),
                    1 => $this->memory[$this->ic + $i],
                    default => throw new \Exception('Invalid input'),
                };
            }
            if (($opcode == 3) and ($this->idxInput >= count($this->inputs))) {
                return;
            }
            $oldIc = $this->ic;
            match ($opcode) {
                1 => $this->memory[$this->memory[$this->ic + 3]] = $params[1] + $params[2],
                2 => $this->memory[$this->memory[$this->ic + 3]] = $params[1] * $params[2],
                3 => $this->memory[$this->memory[$this->ic + 1]] = $this->inputs[$this->idxInput++],
                4 => $this->outputs[] = $params[1],
                5 => $this->ic = $params[1] != 0 ? $params[2] : $this->ic,
                6 => $this->ic = $params[1] == 0 ? $params[2] : $this->ic,
                7 => $this->memory[$this->memory[$this->ic + 3]] = $params[1] < $params[2] ? 1 : 0,
                // @phpstan-ignore match.alwaysTrue
                8 => $this->memory[$this->memory[$this->ic + 3]] = $params[1] == $params[2] ? 1 : 0,
                default => throw new \Exception('Invalid input'),
            };
            if ($this->ic == $oldIc) {
                $this->ic += $len;
            }
        }
    }
}

<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2019;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2019 Day 21: Springdroid Adventure.
 *
 * Part 1: What amount of hull damage does it report?
 * Part 2: What amount of hull damage does the springdroid now report?
 *
 * Topics: assembly simulation
 *
 * @see https://adventofcode.com/2019/day/21
 *
 * @codeCoverageIgnore
 */
final class Aoc2019Day21 extends SolutionBase
{
    public const YEAR = 2019;
    public const DAY = 21;
    public const TITLE = 'Springdroid Adventure';
    public const SOLUTIONS = [19354818, 1143787220];

    private const CODE_PART1 = [
        'NOT D J',
        'NOT J J',
        'NOT C T',
        'AND T J',
        'NOT A T',
        'OR T J',
        'WALK',
    ];
    private const CODE_PART2 = [
        'NOT B J',
        'NOT C T',
        'OR T J',
        'AND D J',
        'AND H J',
        'NOT A T',
        'OR T J',
        'RUN',
    ];

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
        $spring = new SpringDroidSimulator($memory);
        foreach (self::CODE_PART1 as $line) {
            $spring->stringInput($line);
        }
        $spring->simulate();
        $ans1 = $spring->nextOutputOrDebug();
        // ---------- Part 2
        $ans2 = 0;
        $spring = new SpringDroidSimulator($memory);
        foreach (self::CODE_PART2 as $line) {
            $spring->stringInput($line);
        }
        $spring->simulate();
        $ans2 = $spring->nextOutputOrDebug();
        return [strval($ans1), strval($ans2)];
    }
}

// --------------------------------------------------------------------
final class SpringDroidSimulator
{
    private const INSTRUCTION_LENGTHS =
        [1 => 4, 2 => 4, 3 => 2, 4 => 2, 5 => 3, 6 => 3, 7 => 4, 8 => 4, 9 => 2, 99 => 1];
    private const LF = 10;

    /** @var array<int, int> */
    public array $inputs = [];
    /** @var array<int, int> */
    public array $outputs = [];
    public bool $halted = false;

    private int $ic = 0;
    private int $idxInput = 0;
    private int $idxOutput = 0;
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

    public function stringInput(string $line): void
    {
        for ($i = 0; $i < strlen($line); ++$i) {
            $this->inputs[] = ord($line[$i]);
        }
        $this->inputs[] = self::LF;
    }

    public function nextOutputOrDebug(): int
    {
        if (($this->idxOutput < 0) or ($this->idxOutput >= count($this->outputs))) {
            // @codeCoverageIgnoreStart
            throw new \Exception('Output unavailable');
            // @codeCoverageIgnoreEnd
        }
        $message = '';
        for ($i = $this->idxOutput; $i < count($this->outputs); ++$i) {
            $message .= chr($this->outputs[$i]);
        }
        $this->idxOutput = count($this->outputs);
        $ans = $this->outputs[$this->idxOutput - 1];
        if (($ans >= 0) and ($ans <= 255)) {
            echo $message;
            return 0;
        }
        return $ans;
    }
}

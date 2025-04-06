<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2019;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2019 Day 23: Category Six.
 *
 * Part 1: What is the Y value of the first packet sent to address 255?
 * Part 2: What is the first Y value delivered by the NAT to the computer at address 0 twice in a row?
 *
 * @see https://adventofcode.com/2019/day/23
 */
final class Aoc2019Day23 extends SolutionBase
{
    public const YEAR = 2019;
    public const DAY = 23;
    public const TITLE = 'Category Six';
    public const SOLUTIONS = [24922, 19478];

    private const MAX_NICS = 50;

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
        $ans1 = 0;
        $ans2 = 0;
        $part1Completed = false;
        $part2Completed = false;
        $nics = [];
        $incomingQueues = array_fill(0, self::MAX_NICS, []);
        $wasSentByNat = [];
        $nat = [0, 0];
        for ($i = 0; $i < self::MAX_NICS; ++$i) {
            $nics[$i] = new NICSimulator($memory);
            $nics[$i]->inputs[] = $i; // give network address
        }
        while (true) {
            $isIdle = true;
            for ($i = 0; $i < self::MAX_NICS; ++$i) {
                if (count($incomingQueues[$i]) != 0) {
                    $isIdle = false;
                }
                $nics[$i]->receivePackets($incomingQueues[$i]);
                $incomingQueues[$i] = [];
                $nics[$i]->simulate();
                $packets = $nics[$i]->readSentPackets();
                if (count($packets) != 0) {
                    $isIdle = false;
                }
                foreach ($packets as [$destination, $x, $y]) {
                    if ($destination == 255) {
                        if (!$part1Completed) {
                            $ans1 = $y;
                            $part1Completed = true;
                        }
                        $nat = [$x, $y];
                    } else {
                        $incomingQueues[$destination][] = [$x, $y];
                    }
                }
            }
            if ($isIdle) {
                $incomingQueues[0][] = $nat;
                [$x, $y] = $nat;
                if (isset($wasSentByNat[$y])) {
                    $ans2 = $y;
                    $part2Completed = true;
                }
                $wasSentByNat[$y] = true;
            }
            if ($part1Completed and $part2Completed) {
                break;
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}

// --------------------------------------------------------------------
final class NICSimulator
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
                // @phpstan-ignore match.alwaysTrue
                9 => $this->relBase += $params[1],
                default => throw new \Exception('Invalid input'),
            };
            if ($this->ic == $oldIc) {
                $this->ic += $len;
            }
        }
    }

    /**
     * @param array<int, array<int, int>> $packets
     */
    public function receivePackets(array $packets): void
    {
        if (count($packets) == 0) {
            $this->inputs[] = -1;
            return;
        }
        foreach ($packets as $packet) {
            $this->inputs[] = $packet[0];
            $this->inputs[] = $packet[1];
        }
    }

    /**
     * @return array<int, array<int, int>>
     */
    public function readSentPackets(): array
    {
        if (($this->idxOutput < 0) or ($this->idxOutput >= count($this->outputs))) {
            return [];
        }
        $ans = [];
        while ($this->idxOutput + 2 < count($this->outputs)) {
            $ans[] = array_slice($this->outputs, $this->idxOutput, 3);
            $this->idxOutput += 3;
        }
        return $ans;
    }
}

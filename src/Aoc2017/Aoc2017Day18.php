<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2017;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2017 Day 18: Duet.
 *
 * Part 1: What is the value of the recovered frequency (the value of the most recently played sound)
 *         the first time a rcv instruction is executed with a non-zero value?
 * Part 2: Once both of your programs have terminated (regardless of what caused them to do so),
 *         how many times did program 1 send a value?
 *
 * Topics: assembly simulation, coroutines
 *
 * @see https://adventofcode.com/2017/day/18
 */
final class Aoc2017Day18 extends SolutionBase
{
    public const YEAR = 2017;
    public const DAY = 18;
    public const TITLE = 'Duet';
    public const SOLUTIONS = [9423, 7620];
    public const EXAMPLE_SOLUTIONS = [[4, 0], [0, 3]];

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
        $thread = new Thread($input);
        $thread->execute();
        $ans1 = $thread->sound;
        // ---------- Part 2
        $thread0 = new Thread($input, 0, false);
        $thread1 = new Thread($input, 1, false);
        while (true) {
            $wasComm = false;
            $thread0->execute();
            while (count($thread0->sndQueue) > 0) {
                $thread1->rcvQueue[] = array_shift($thread0->sndQueue);
                $wasComm = true;
            }
            $thread1->execute();
            while (count($thread1->sndQueue) > 0) {
                $thread0->rcvQueue[] = array_shift($thread1->sndQueue);
                $wasComm = true;
            }
            if ($thread0->completed and $thread1->completed) {
                break;
            }
            if (!$wasComm) {
                break;
            }
        }
        $ans2 = $thread1->totalSent;
        return [strval($ans1), strval($ans2)];
    }
}

// --------------------------------------------------------------------
final class Thread
{
    public readonly bool $isPartOne;
    public readonly int $id;
    /** @var array<int, string> */
    public readonly array $instructions;

    /** @var array<int, int> */
    public array $sndQueue;
    /** @var array<int, int> */
    public array $rcvQueue;
    public bool $waitToReceive;
    public bool $completed;
    public int $sound;
    public int $totalSent;

    /** @var array<string, int> */
    private array $registers;
    private int $pc;

    /**
     * @param array<int, string> $input The lines of the input, without LF
     */
    public function __construct(array $input, int $id = 0, bool $isPartOne = true)
    {
        $this->id = $id;
        $this->isPartOne = $isPartOne;
        $this->instructions = $input;
        $this->sndQueue = [];
        $this->rcvQueue = [];
        $this->waitToReceive = false;
        $this->completed = false;
        $this->sound = -1;
        $this->totalSent = 0;
        $this->registers = ['p' => $id];
        $this->pc = -1;
    }

    public function execute(): void
    {
        while (true) {
            if (!$this->waitToReceive) {
                ++$this->pc;
            } elseif (count($this->rcvQueue) == 0) {
                return;
            }
            if (($this->pc < 0) or ($this->pc >= count($this->instructions))) {
                $this->waitToReceive = false;
                $this->completed = true;
                return;
            }
            if ((strlen($this->instructions[$this->pc]) < 5) or ($this->instructions[$this->pc][3] != ' ')) {
                throw new \Exception('Invalid instruction');
            }
            $instruction = substr($this->instructions[$this->pc], 0, 3);
            $xReg = $this->instructions[$this->pc][4];
            if (($xReg >= 'a') and ($xReg <= 'z')) {
                $xValue = $this->registers[$xReg] ?? 0;
            } else {
                $xValue = intval($xReg);
            }
            switch ($instruction) {
                case 'snd':
                    if ($this->isPartOne) {
                        $this->sound = $xValue;
                        continue 2;
                    }
                    ++$this->totalSent;
                    $this->sndQueue[] = $xValue;
                    continue 2;
                case 'rcv':
                    if ($this->isPartOne) {
                        if ($xValue != 0) {
                            $this->completed = true;
                            return;
                        }
                        continue 2;
                    }
                    if (count($this->rcvQueue) == 0) {
                        $this->waitToReceive = true;
                        return;
                    }
                    $this->waitToReceive = false;
                    $yValue = array_shift($this->rcvQueue);
                    $this->registers[$xReg] = $yValue;
                    continue 2;
            }
            if ((strlen($this->instructions[$this->pc]) < 7) or ($this->instructions[$this->pc][5] != ' ')) {
                throw new \Exception('Invalid instruction');
            }
            $yReg = $this->instructions[$this->pc][6];
            if (($yReg >= 'a') and ($yReg <= 'z')) {
                $yValue = $this->registers[$yReg] ?? 0;
            } else {
                $yValue = intval(substr($this->instructions[$this->pc], 6));
            }
            switch ($instruction) {
                case 'set':
                    $this->registers[$xReg] = $yValue;
                    break;
                case 'add':
                    $this->registers[$xReg] = $xValue + $yValue;
                    break;
                case 'mul':
                    $this->registers[$xReg] = $xValue * $yValue;
                    break;
                case 'mod':
                    $this->registers[$xReg] = $xValue % $yValue;
                    break;
                case 'jgz':
                    if ($xValue > 0) {
                        $this->pc += $yValue - 1;
                    }
                    break;
                default:
                    throw new \Exception('Invalid instruction');
            }
        }
    }
}

<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2017;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2017 Day 23: Coprocessor Conflagration.
 *
 * Part 1: If you run the program (your puzzle input), how many times is the mul instruction invoked?
 * Part 2: After setting register a to 1, if the program were to run to completion,
 *         what value would be left in register h?
 *
 * Topics: assembly simulation
 *
 * @see https://adventofcode.com/2017/day/23
 */
final class Aoc2017Day23 extends SolutionBase
{
    public const YEAR = 2017;
    public const DAY = 23;
    public const TITLE = 'Coprocessor Conflagration';
    public const SOLUTIONS = [8281, 0];
    public const EXAMPLE_SOLUTIONS = [];

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
        $proc = new CoProcessor($input);
        $proc->execute();
        $ans1 = $proc->totalMuls;
        // ---------- Part 2
        $ans2 = 0;
        return [strval($ans1), strval($ans2)];
    }
}

// --------------------------------------------------------------------
final class CoProcessor
{
    public readonly bool $isPartOne;
    /** @var array<int, string> */
    public readonly array $instructions;
    public int $totalMuls;
    /** @var array<string, int> */
    private array $registers;
    private int $pc;

    /**
     * @param array<int, string> $input The lines of the input, without LF
     */
    public function __construct(array $input, bool $isPartOne = true)
    {
        $this->isPartOne = $isPartOne;
        $this->instructions = $input;
        $this->totalMuls = 0;
        $this->registers = [];
        if (!$isPartOne) {
            $this->registers['a'] = 1;
        }
        $this->pc = -1;
    }

    public function execute(): void
    {
        while (true) {
            ++$this->pc;
            if (($this->pc < 0) or ($this->pc >= count($this->instructions))) {
                return;
            }
            if (
                (strlen($this->instructions[$this->pc]) < 7)
                or ($this->instructions[$this->pc][3] != ' ')
                or ($this->instructions[$this->pc][5] != ' ')
            ) {
                throw new \Exception('Invalid instruction');
            }
            $instruction = substr($this->instructions[$this->pc], 0, 3);
            $xReg = $this->instructions[$this->pc][4];
            if (($xReg >= 'a') and ($xReg <= 'z')) {
                $xValue = $this->registers[$xReg] ?? 0;
            } else {
                $xValue = intval($xReg);
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
                case 'sub':
                    $this->registers[$xReg] = $xValue - $yValue;
                    break;
                case 'mul':
                    $this->registers[$xReg] = $xValue * $yValue;
                    ++$this->totalMuls;
                    break;
                case 'jnz':
                    if ($xValue != 0) {
                        $this->pc += $yValue - 1;
                    }
                    break;
                default:
                    throw new \Exception('Invalid instruction');
            }
        }
    }
}

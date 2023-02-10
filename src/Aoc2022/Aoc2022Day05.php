<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2022;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2022 Day 5: Supply Stacks.
 *
 * Part 1: After the rearrangement procedure completes, what crate ends up on top of each stack?
 * Part 2: The CrateMover 9001 is notable for the ability to pick up and move multiple crates at once.
 *         After the rearrangement procedure completes, what crate ends up on top of each stack?
 *
 * @see https://adventofcode.com/2022/day/5
 */
final class Aoc2022Day05 extends SolutionBase
{
    public const YEAR = 2022;
    public const DAY = 5;
    public const TITLE = 'Supply Stacks';
    public const SOLUTIONS = ['NTWZZWHFV', 'BRZGFVBTJ'];
    public const EXAMPLE_SOLUTIONS = [['CMZ', 'MCD']];

    /** @var array<int, string> */
    private array $startStacks = [];
    /** @var array<int, Instruction> */
    private array $instructions = [];

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
        $this->parseInput($input);
        // ---------- Part 1
        $stacks = $this->startStacks;
        foreach ($this->instructions as $instr) {
            $stacks[$instr->to] .= strrev(substr($stacks[$instr->from], -$instr->qty));
            $stacks[$instr->from] = substr($stacks[$instr->from], 0, -$instr->qty);
        }
        $ans1 = '';
        foreach ($stacks as $stack) {
            $ans1 .= $stack[strlen($stack) - 1] ?? '';
        }
        // ---------- Part 2
        $stacks = $this->startStacks;
        foreach ($this->instructions as $instr) {
            $stacks[$instr->to] .= substr($stacks[$instr->from], -$instr->qty);
            $stacks[$instr->from] = substr($stacks[$instr->from], 0, -$instr->qty);
        }
        $ans2 = '';
        foreach ($stacks as $stack) {
            $ans2 .= $stack[strlen($stack) - 1] ?? '';
        }
        return [$ans1, $ans2];
    }

    /**
     * Parse input, sets startStacks and instructions.
     *
     * @param array<int, string> $input The lines of the input, without LF
     */
    private function parseInput(array $input): void
    {
        $this->startStacks = [];
        $this->instructions = [];
        $idxEmpty = array_search('', $input, true);
        if (($idxEmpty === false) or ($idxEmpty < 2)) {
            throw new \Exception('Invalid input');
        }
        $countStacks = intdiv(strlen($input[$idxEmpty - 1]) + 2, 4);
        $this->startStacks = array_fill(0, $countStacks, '');
        for ($i = $idxEmpty - 2; $i >= 0; --$i) {
            for ($idxStack = 0; $idxStack < $countStacks; ++$idxStack) {
                $c = $input[$i][$idxStack * 4 + 1] ?? ' ';
                if ($c == ' ') {
                    continue;
                }
                $this->startStacks[$idxStack] .= $c;
            }
        }
        for ($i = $idxEmpty + 1; $i < count($input); ++$i) {
            if (
                !str_contains($input[$i], 'move ')
                or !str_contains($input[$i], ' from ')
                or !str_contains($input[$i], ' to ')
            ) {
                // @codeCoverageIgnoreStart
                throw new \Exception('Invalid input');
                // @codeCoverageIgnoreEnd
            }
            $a = explode(' from ', $input[$i]);
            $b = explode(' ', $a[0]);
            $c = explode(' to ', $a[1]);
            $qty = intval($b[1]);
            $from = intval($c[0]);
            $to = intval($c[1]);
            if (($from < 1) or ($from > $countStacks) or ($to < 1) or ($to > $countStacks) or ($from == $to)) {
                // @codeCoverageIgnoreStart
                throw new \Exception('Invalid input');
                // @codeCoverageIgnoreEnd
            }
            $this->instructions[] = new Instruction($qty, $from - 1, $to - 1);
        }
    }
}

// --------------------------------------------------------------------
final class Instruction
{
    public function __construct(
        public readonly int $qty,
        public readonly int $from,
        public readonly int $to,
    ) {
    }
}

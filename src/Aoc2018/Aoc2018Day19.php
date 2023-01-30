<?php

declare(strict_types=1);

namespace TBali\Aoc2018;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2018 Day 19: Go With The Flow.
 *
 * Part 1: What value is left in register 0 when the background process halts?
 * Part 2: What value is left in register 0 when this new background process halts?
 *
 * Topics: assembly simulation, reverse engineering
 *
 * @see https://adventofcode.com/2018/day/19
 */
final class Aoc2018Day19 extends SolutionBase
{
    public const YEAR = 2018;
    public const DAY = 19;
    public const TITLE = 'Go With The Flow';
    public const SOLUTIONS = [2106, 23021280];
    public const EXAMPLE_SOLUTIONS = [[6, 0]];

    private const SIM_PART1 = false;
    private const SIM_PART2 = false;
    private const DISPLAY_TRACE = false;

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
        // ---------- Parse input
        if (!str_starts_with($input[0], '#ip ')) {
            throw new \Exception('Invalid input');
        }
        $ipReg = intval(substr($input[0], 4));
        $instructions = [];
        for ($i = 1; $i < count($input); ++$i) {
            $a = explode(' ', $input[$i]);
            $instructions[] = [$a[0], intval($a[1]), intval($a[2]), intval($a[3])];
        }
        // ---------- Part 1
        $regs = array_fill(0, 6, 0);
        $target1 = 0;
        // @phpstan-ignore-next-line
        if ((count($instructions) == 7) or self::SIM_PART1) {
            $ip = 0;
            while (true) {
                if (($ip == 26) and ($target1 == 0)) {
                    // @codeCoverageIgnoreStart
                    $target1 = $regs[2];
                    // @codeCoverageIgnoreEnd
                }
                if (($ip < 0) or ($ip >= count($instructions))) {
                    break;
                }
                $regs[$ipReg] = $ip;
                $regs = self::execute($instructions[$ip], $regs);
                $ip = $regs[$ipReg];
                ++$ip;
            }
            $ans1 = $regs[0];
        } else {
            $target1 = ($instructions[17][2] ** 2) * 19 * $instructions[20][2]
                + ($instructions[21][2] * 22 + $instructions[23][2]);
            // the assembly code in puzzle input calculates the sum of divisors for $target
            $ans1 = self::sumDivisors($target1);
        }
        // early exit for example input
        if (count($instructions) == 7) {
            return [strval($ans1), '0'];
        }
        // ---------- Part 2
        $regs = array_fill(0, 6, 0);
        $regs[0] = 1;
        $target2 = 0;
        // @phpstan-ignore-next-line
        if (self::SIM_PART2) {
            // @codeCoverageIgnoreStart
            $ip = 0;
            $maxSteps = 150;
            while (true) {
                // @phpstan-ignore-next-line
                if (($ip == 35) and ($target2 == 0)) {
                    $target2 = $regs[2];
                    // @phpstan-ignore-next-line
                    if (!self::DISPLAY_TRACE) {
                        break;
                    }
                }
                if (($ip < 0) or ($ip >= count($instructions))) {
                    break;
                }
                // @phpstan-ignore-next-line
                if (self::DISPLAY_TRACE) {
                    echo $ip . ' : ' . implode(' ', $instructions[$ip]) . ' : [' . implode(', ', $regs) . '] ', PHP_EOL;
                }
                $regs[$ipReg] = $ip;
                $regs = self::execute($instructions[$ip], $regs);
                $ip = $regs[$ipReg];
                ++$ip;
                --$maxSteps;
                if ($maxSteps == 0) {
                    break;
                }
            }
        // @codeCoverageIgnoreEnd
        } else {
            $target2 = $target1 + (27 * 28 + 29) * 30 * $instructions[31][2] * 32;
        }
        $ans2 = self::sumDivisors($target2);
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param array<int, mixed> $instr
     * @param array<int, int>   $regs
     *
     * @phpstan-param array{string, int, int, int} $instr
     *
     * @return array<int, int> The registers after executing the instruction
     *
     * @codeCoverageIgnore
     */
    private static function execute(array $instr, array $regs): array
    {
        $regs[$instr[3]] = match ($instr[0]) {
            'addr' => $regs[$instr[1]] + $regs[$instr[2]], // addr
            'addi' => $regs[$instr[1]] + $instr[2], // addi
            'mulr' => $regs[$instr[1]] * $regs[$instr[2]], // mulr
            'muli' => $regs[$instr[1]] * $instr[2], // muli
            'banr' => $regs[$instr[1]] & $regs[$instr[2]], // banr
            'bani' => $regs[$instr[1]] & $instr[2], // bani
            'borr' => $regs[$instr[1]] | $regs[$instr[2]], // borr
            'bori' => $regs[$instr[1]] | $instr[2], // bori
            'setr' => $regs[$instr[1]], // setr
            'seti' => $instr[1], // seti
            'gtir' => $instr[1] > ($regs[$instr[2]]) ? 1 : 0, // gtir
            'gtri' => $regs[$instr[1]] > ($instr[2]) ? 1 : 0, // gtri
            'gtrr' => $regs[$instr[1]] > ($regs[$instr[2]]) ? 1 : 0, // gtrr
            'eqir' => $instr[1] == ($regs[$instr[2]]) ? 1 : 0, // eqir
            'eqri' => $regs[$instr[1]] == ($instr[2]) ? 1 : 0, // eqri
            'eqrr' => $regs[$instr[1]] == ($regs[$instr[2]]) ? 1 : 0, // eqrr
            default => throw new \Exception('Invalid'),
        };
        return $regs;
    }

    private static function sumDivisors(int $n): int
    {
        $ans = 0;
        for ($i = 1; $i <= $n; ++$i) {
            if ($n % $i == 0) {
                $ans += $i;
            }
        }
        return $ans;
    }
}

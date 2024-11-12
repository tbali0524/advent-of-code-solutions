<?php

declare(strict_types=1);

namespace TBali\Aoc2018;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2018 Day 21: Chronal Conversion.
 *
 * Part 1: What is the lowest non-negative integer value for register 0 that causes the program to halt
 *         after executing the fewest instructions?
 * Part 2: What is the lowest non-negative integer value for register 0 that causes the program to halt
 *         after executing the most instructions?
 *
 * Topics: assembly simulation, reverse engineering
 *
 * @see https://adventofcode.com/2018/day/21
 */
final class Aoc2018Day21 extends SolutionBase
{
    public const YEAR = 2018;
    public const DAY = 21;
    public const TITLE = 'Chronal Conversion';
    public const SOLUTIONS = [3941014, 13775890];

    private const SIM = false;
    private const DEBUG = false;

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
        // ---------- Part 1 + 2
        $ans1 = 0;
        $ans2 = 0;
        // @phpstan-ignore booleanNot.alwaysTrue
        if (!self::SIM) {
            $c1 = $instructions[7][1];
            $c2 = $instructions[11][2];
            $memo = [];
            $prev = 0;
            $step = 0;
            $maxSteps = 5;
            while (true) {
                $r5 = $c1;
                $r4 = $prev | 0x10000;
                $r5 = ((($r5 + ($r4 & 0xFF)) & 0xFFFFFF) * $c2) & 0xFFFFFF;
                $r4 >>= 8;
                $r5 = ((($r5 + ($r4 & 0xFF)) & 0xFFFFFF) * $c2) & 0xFFFFFF;
                $r4 >>= 8;
                $r5 = ((($r5 + ($r4 & 0xFF)) & 0xFFFFFF) * $c2) & 0xFFFFFF;
                // @phpstan-ignore if.alwaysFalse,logicalAnd.leftAlwaysFalse
                if (self::DEBUG and ($step < $maxSteps)) {
                    // @codeCoverageIgnoreStart
                    echo '#' . $step . ': 0x' . str_pad(dechex($r5), 8, '0', STR_PAD_LEFT), PHP_EOL;
                    // @codeCoverageIgnoreEnd
                }
                ++$step;
                if ($ans1 == 0) {
                    $ans1 = $r5;
                }
                if (isset($memo[$r5])) {
                    $ans2 = $prev;
                    break;
                }
                $memo[$r5] = true;
                $prev = $r5;
            }
            return [strval($ans1), strval($ans2)];
        }
        // @codeCoverageIgnoreStart
        // @phpstan-ignore deadCode.unreachable
        $maxSteps = 5;
        $regs = array_fill(0, 6, 0);
        $prev = 0;
        $ip = 0;
        while (true) {
            if ($ip == 28) {
                if ($ans1 == 0) {
                    $ans1 = $regs[5];
                }
                if ($maxSteps == 0) {
                    break;
                }
                --$maxSteps;
            }
            if (($ip < 0) or ($ip >= count($instructions))) {
                break;
            }
            $regs[$ipReg] = $ip;
            $prev = $regs[5];
            $regs = self::execute($instructions[$ip], $regs);
            if (self::DEBUG and (($prev != $regs[5]) or ($ip == 13) or ($ip == 28))) {
                if ($ip == 28) {
                    echo '-- check:', PHP_EOL;
                }
                echo str_pad(strval($ip), 2) . ' : ' . str_pad(implode(' ', $instructions[$ip]), 20) . ' : ['
                    . implode(', ', array_map(static fn ($x) => str_pad(dechex($x), 6, '0', STR_PAD_LEFT), $regs))
                    . '] ', PHP_EOL;
            }
            $ip = $regs[$ipReg];
            ++$ip;
        }
        return [strval($ans1), strval($ans2)];
        // @codeCoverageIgnoreEnd
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
     *
     * @phpstan-ignore method.unused
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
}

<?php

declare(strict_types=1);

namespace TBali\Aoc2018;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2018 Day 16: Chronal Classification.
 *
 * Part 1: Ignoring the opcode numbers, how many samples in your puzzle input behave like three or more opcodes?
 * Part 2: What value is contained in register 0 after executing the test program?
 *
 * Topics: assembly simulation, matching in bipartite graph
 *
 * @see https://adventofcode.com/2018/day/16
 */
final class Aoc2018Day16 extends SolutionBase
{
    public const YEAR = 2018;
    public const DAY = 16;
    public const TITLE = 'Chronal Classification';
    public const SOLUTIONS = [605, 653];
    public const EXAMPLE_SOLUTIONS = [[1, 0]];

    private const MAX_OPCODE = 16;

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
        $sampleBefores = [];
        $sampleInstructions = [];
        $sampleAfters = [];
        $instructions = [];
        $i = 0;
        while (true) {
            if (($input[$i] ?? '') == '') {
                break;
            }
            if (
                ($i + 4 >= count($input))
                or !str_starts_with($input[$i], 'Before: [')
                or !str_starts_with($input[$i + 2], 'After:  [')
                or ($input[$i + 3] != '')
            ) {
                throw new \Exception('Invalid input');
            }
            $sampleBefores[] = array_map(intval(...), explode(', ', substr($input[$i], 9, -1)));
            $sampleInstructions[] = array_map(intval(...), explode(' ', $input[$i + 1]));
            $sampleAfters[] = array_map(intval(...), explode(', ', substr($input[$i + 2], 9, -1)));
            $i += 4;
        }
        while (($i < count($input)) and ($input[$i] == '')) {
            ++$i;
        }
        while ($i < count($input)) {
            $instructions[] = array_map(intval(...), explode(' ', $input[$i]));
            ++$i;
        }
        // ---------- Part 1
        $ans1 = 0;
        // bitmask for each opcode in sample input: bit x == 1 iff opcode #x is possible
        $possibleMasks = array_fill(0, self::MAX_OPCODE, (1 << self::MAX_OPCODE) - 1);
        for ($i = 0; $i < count($sampleInstructions); ++$i) {
            $countOk = 0;
            $possibleMask = 0;
            for ($opcode = 0; $opcode < self::MAX_OPCODE; ++$opcode) {
                if (self::execute($opcode, $sampleInstructions[$i], $sampleBefores[$i]) === $sampleAfters[$i]) {
                    ++$countOk;
                    $possibleMask |= (1 << $opcode);
                }
            }
            $possibleMasks[$sampleInstructions[$i][0]] &= $possibleMask;
            if ($countOk >= 3) {
                ++$ans1;
            }
        }
        // early exit for example input
        if (count($sampleInstructions) <= 1) {
            return [strval($ans1), '0'];
        }
        // ---------- Part 2
        $ans2 = 0;
        $matchings = [];
        // @phpstan-ignore-next-line
        while (count($matchings) < self::MAX_OPCODE) {
            for ($opcode = 0; $opcode < self::MAX_OPCODE; ++$opcode) {
                if (isset($matchings[$opcode])) {
                    continue;
                }
                if (self::countOne($possibleMasks[$opcode]) != 1) {
                    continue;
                }
                $realOpcode = 0;
                while (($possibleMasks[$opcode] & 1) == 0) {
                    ++$realOpcode;
                    $possibleMasks[$opcode] >>= 1;
                }
                $matchings[$opcode] = $realOpcode;
                for ($i = 0; $i < self::MAX_OPCODE; ++$i) {
                    $possibleMasks[$i] &= ~(1 << $realOpcode);
                }
            }
        }
        // @phpstan-ignore-next-line
        $regs = [0, 0, 0, 0];
        foreach ($instructions as $instruction) {
            $regs = self::execute($matchings[$instruction[0]], $instruction, $regs);
        }
        $ans2 = $regs[0];
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param array<int, int> $instr
     * @param array<int, int> $regs
     *
     * @return array<int, int> The registers after executing the instruction
     */
    private static function execute(int $opcode, array $instr, array $regs): array
    {
        $regs[$instr[3]] = match ($opcode) {
            0 => ($regs[$instr[1]] ?? 0) + ($regs[$instr[2]] ?? 0), // addr
            1 => ($regs[$instr[1]] ?? 0) + ($instr[2] ?? 0), // addi
            2 => ($regs[$instr[1]] ?? 0) * ($regs[$instr[2]] ?? 0), // mulr
            3 => ($regs[$instr[1]] ?? 0) * ($instr[2] ?? 0), // muli
            4 => ($regs[$instr[1]] ?? 0) & ($regs[$instr[2]] ?? 0), // banr
            5 => ($regs[$instr[1]] ?? 0) & ($instr[2] ?? 0), // bani
            6 => ($regs[$instr[1]] ?? 0) | ($regs[$instr[2]] ?? 0), // borr
            7 => ($regs[$instr[1]] ?? 0) | ($instr[2] ?? 0), // bori
            8 => ($regs[$instr[1]] ?? 0), // setr
            9 => ($instr[1] ?? 0), // seti
            10 => ($instr[1] ?? 0) > ($regs[$instr[2]] ?? 0) ? 1 : 0, // gtir
            11 => ($regs[$instr[1]] ?? 0) > ($instr[2] ?? 0) ? 1 : 0, // gtri
            12 => ($regs[$instr[1]] ?? 0) > ($regs[$instr[2]] ?? 0) ? 1 : 0, // gtrr
            13 => ($instr[1] ?? 0) == ($regs[$instr[2]] ?? 0) ? 1 : 0, // eqir
            14 => ($regs[$instr[1]] ?? 0) == ($instr[2] ?? 0) ? 1 : 0, // eqri
            15 => ($regs[$instr[1]] ?? 0) == ($regs[$instr[2]] ?? 0) ? 1 : 0, // eqrr
            default => throw new \Exception('Invalid'),
        };
        return $regs;
    }

    /** counts the number of 1 bits */
    private static function countOne(int $x): int
    {
        $ans = 0;
        while ($x != 0) {
            if (($x & 1) != 0) {
                ++$ans;
            }
            $x >>= 1;
        }
        return $ans;
    }
}

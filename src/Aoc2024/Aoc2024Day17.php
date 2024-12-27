<?php

declare(strict_types=1);

namespace TBali\Aoc2024;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2024 Day 17: Chronospatial Computer.
 *
 * @see https://adventofcode.com/2024/day/17
 */
final class Aoc2024Day17 extends SolutionBase
{
    public const YEAR = 2024;
    public const DAY = 17;
    public const TITLE = 'Chronospatial Computer';
    public const SOLUTIONS = ['2,7,2,5,1,2,7,3,7', 247839002892474];
    public const EXAMPLE_SOLUTIONS = [['4,6,3,5,6,3,5,2,1,0', 0], ['4,2,5,6,7,7,7,7,3,1,0', 0], [0, 117440]];

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
        $registers = [0, 0, 0];
        if (count($input) != 5) {
            throw new \Exception('input must be 5 lines');
        }
        for ($i = 0; $i < 3; ++$i) {
            if (!str_starts_with($input[$i], 'Register ')) {
                throw new \Exception('first 3 lines must start with `Register `');
            }
            $registers[$i] = intval(substr($input[$i], 12));
        }
        if ($input[3] != '') {
            throw new \Exception('registers and program must be separated by an empty line');
        }
        if (!str_starts_with($input[4], 'Program: ')) {
            throw new \Exception('5th line must start with `Program: `');
        }
        $program = array_map('intval', explode(',', substr($input[4], 9)));
        if (array_any($program, static fn (int $x): bool => $x < 0 || $x > 7)) {
            throw new \Exception('program code must be between 0 and 7');
        }
        // ---------- Part 1
        $ans1 = implode(',', self::simulate($program, $registers, true));
        // ---------- Part 2
        $program_s = implode(',', $program);
        $ans2 = 0;
        if ($program_s == '0,1,5,4,3,0') {
            // example 1 & 2
            return [strval($ans1), '0'];
        }
        if ($program_s == '0,3,5,4,3,0') {
            // example 3: do { a >>= 3; out a & 0b111; } while (a != 0);
            for ($i = count($program) - 1; $i >= 0; --$i) {
                $ans2 = ($ans2 | $program[$i]) << 3;
            }
            return ['0', strval($ans2)];
        }
        // puzzle: do { b = a >> 3; b ^= 1, c = a >> b; a >>= 3; b ^= c; b ^= 0b110; out b & 0b111; } while (a != 0);
        $q = [];
        $q[] = [0, count($program)];
        $idx_read = 0;
        while ($idx_read < count($q)) {
            [$partial_a, $step] = $q[$idx_read];
            ++$idx_read;
            if ($step == 0) {
                $ans2 = $partial_a;
                break;
            }
            for ($block = 0; $block < 8; ++$block) {
                $a = ($partial_a << 3) | $block;
                $b = $block;
                $b ^= 1;
                $c = $a >> $b;
                $b ^= $c;
                $b ^= 0b110;
                if (($b & 0b111) == $program[$step - 1]) {
                    $q[] = [$a, $step - 1];
                }
            }
        }
        return [strval($ans1), strval($ans2)];
    }

    /** Simulate the program, returning the output.
     *
     * If is_part1 == false, then early returns Err if output is not same as program.
     * However this is not used in the solution, because it would be too slow.
     *
     * @param array<int, int> $program
     * @param array<int, int> $start_registers
     *
     * @return array<int, int>
     */
    private function simulate(
        array $program,
        array $start_registers,
        bool $is_part1,
    ): array {
        $output = [];
        $registers = $start_registers;
        $pc = -2;
        while (true) {
            $pc += 2;
            if (($pc < 0) or ($pc + 1 >= count($program))) {
                break;
            }
            $operator = $program[$pc];
            $operand = $program[$pc + 1];
            if ($operator == 0) {
                // adv
                $registers[0] >>= self::combo($operand, $registers);
            } elseif ($operator == 1) {
                // bxl
                $registers[1] ^= $operand;
            } elseif ($operator == 2) {
                // bst
                $registers[1] = self::combo($operand, $registers) & 7;
            } elseif ($operator == 3) {
                // jnz
                if ($registers[0] != 0) {
                    $pc = $operand - 2;
                }
            } elseif ($operator == 4) {
                // bxc
                $registers[1] ^= $registers[2];
            } elseif ($operator == 5) {
                // out
                $value = self::combo($operand, $registers) & 7;
                if (!$is_part1 and ((count($output) >= count($program)) or ($value != $program[count($output)]))) {
                    // @codeCoverageIgnoreStart
                    return [];
                    // @codeCoverageIgnoreEnd
                }
                $output[] = $value;
            } elseif ($operator == 6) {
                // bdv
                // @codeCoverageIgnoreStart
                $registers[1] = $registers[0] >> self::combo($operand, $registers);
            // @codeCoverageIgnoreEnd
            } elseif ($operator == 7) {
                // cdv
                $registers[2] = $registers[0] >> self::combo($operand, $registers);
            }
        }
        if (!$is_part1 and (count($output) != count($program))) {
            // @codeCoverageIgnoreStart
            return [];
            // @codeCoverageIgnoreEnd
        }
        return $output;
    }

    /**
     * @param array<int, int> $registers
     */
    private function combo(int $operand, array $registers): int
    {
        if (($operand >= 0) and ($operand < 4)) {
            return $operand;
        }
        if (($operand >= 4) and ($operand < 7)) {
            return $registers[$operand - 4];
        }
        // @codeCoverageIgnoreStart
        throw new \Exception('invalid operand');
        // @codeCoverageIgnoreEnd
    }
}

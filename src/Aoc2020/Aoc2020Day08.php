<?php

declare(strict_types=1);

namespace TBali\Aoc2020;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2020 Day 8: Handheld Halting.
 *
 * Part 1: Immediately before any instruction is executed a second time, what value is in the accumulator?
 * Part 2: What is the value of the accumulator after the program terminates?
 *
 * Topics: assembly simulation
 *
 * @see https://adventofcode.com/2020/day/8
 */
final class Aoc2020Day08 extends SolutionBase
{
    public const YEAR = 2020;
    public const DAY = 8;
    public const TITLE = 'Handheld Halting';
    public const SOLUTIONS = [1749, 515];
    public const EXAMPLE_SOLUTIONS = [[5, 8]];

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
        [$wasInfLoop, $ans1] = $this->execute($input);
        if (!$wasInfLoop) {
            // @codeCoverageIgnoreStart
            throw new \Exception('Part 1 supposed to contain an infinite loop');
            // @codeCoverageIgnoreEnd
        }
        // ---------- Part 2
        $ans2 = 0;
        for ($i = 0; $i < count($input); ++$i) {
            $instruction = substr($input[$i], 0, 3);
            if (!in_array($instruction, ['jmp', 'nop'])) {
                continue;
            }
            $modInstruction = ['jmp' => 'nop', 'nop' => 'jmp'][$instruction] ?? 'err';
            $modInput = $input;
            $modInput[$i] = $modInstruction . substr($input[$i], 3);
            [$wasInfLoop, $ans2] = $this->execute($modInput);
            if (!$wasInfLoop) {
                break;
            }
        }
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param array<int, string> $input The lines of the input, without LF
     *
     * @return array<mixed> First item: was there an infinite loop? Second item: The accumulator at exit
     *
     * @phpstan-return array{bool, int}
     */
    private function execute(array $input): array
    {
        $memo = [];
        $a = 0;
        $pc = -1;
        while (true) {
            ++$pc;
            if (($pc < 0) or ($pc >= count($input))) {
                return [false, $a];
            }
            if (isset($memo[$pc])) {
                return [true, $a];
            }
            $memo[$pc] = true;
            $instruction = substr($input[$pc], 0, 3);
            switch ($instruction) {
                case 'acc':
                    $offset = intval(substr($input[$pc], 4));
                    $a += $offset;
                    break;
                case 'jmp':
                    $offset = intval(substr($input[$pc], 4));
                    $pc += $offset - 1;
                    break;
                case 'nop':
                    break;
                default:
                    // @codeCoverageIgnoreStart
                    throw new \Exception('Invalid instruction');
                    // @codeCoverageIgnoreEnd
            }
        }
    }
}

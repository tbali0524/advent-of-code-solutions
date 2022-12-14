<?php

declare(strict_types=1);

namespace TBali\Aoc2015;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2015 Day 23: Opening the Turing Lock.
 *
 * Part 1: What is the value in register b when the program in your puzzle input is finished executing?
 * Part 2: What is the value in register b after the program is finished executing if register a starts as 1 instead?
 *
 * Topics: assembly simulation
 *
 * @see https://adventofcode.com/2015/day/23
 */
final class Aoc2015Day23 extends SolutionBase
{
    public const YEAR = 2015;
    public const DAY = 23;
    public const TITLE = 'Opening the Turing Lock';
    public const SOLUTIONS = [170, 247];
    public const EXAMPLE_SOLUTIONS = [[2, 2]];

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
        // ---------- Part 1 + 2
        $ans1 = $this->execute($input, ['a' => 0, 'b' => 0])['b'] ?? 0;
        $ans2 = $this->execute($input, ['a' => 1, 'b' => 0])['b'] ?? 0;
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param array<int, string> $input     The lines of the input, without LF
     * @param array<string, int> $registers The registers at the start of execution
     *
     * @return array<string, int> The registers at the end of execution
     */
    private function execute(array $input, array $registers): array
    {
        $pc = -1;
        while (true) {
            ++$pc;
            if (($pc < 0) or ($pc >= count($input))) {
                return $registers;
            }
            $instruction = substr($input[$pc], 0, 3);
            switch ($instruction) {
                case 'hlf':
                    $r = $input[$pc][4];
                    $registers[$r] = intdiv($registers[$r] ?? 0, 2);
                    break;
                case 'tpl':
                    $r = $input[$pc][4];
                    $registers[$r] = 3 * ($registers[$r] ?? 0);
                    break;
                case 'inc':
                    $r = $input[$pc][4];
                    $registers[$r] = ($registers[$r] ?? 0) + 1;
                    break;
                case 'jmp':
                    $offset = intval(substr($input[$pc], 4));
                    $pc += $offset - 1;
                    break;
                case 'jie':
                    $r = $input[$pc][4];
                    $offset = intval(substr($input[$pc], 6));
                    if (($registers[$r] ?? -1) % 2 == 0) {
                        $pc += $offset - 1;
                    }
                    break;
                case 'jio':
                    $r = $input[$pc][4];
                    $offset = intval(substr($input[$pc], 6));
                    if (($registers[$r] ?? 0) == 1) {
                        $pc += $offset - 1;
                    }
                    break;
                default:
                    throw new \Exception('Invalid instruction');
            }
        }
    }
}

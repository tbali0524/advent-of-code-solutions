<?php

declare(strict_types=1);

namespace TBali\Aoc2016;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2016 Day 12: Leonardo's Monorail.
 *
 * Part 1: After executing the assembunny code in your puzzle input, what value is left in register a?
 * Part 2: If you instead initialize register c to be 1, what value is now left in register a?
 *
 * Topics: assembly simulation
 *
 * @see https://adventofcode.com/2016/day/12
 */
final class Aoc2016Day12 extends SolutionBase
{
    public const YEAR = 2016;
    public const DAY = 12;
    public const TITLE = 'Leonardo\'s Monorail';
    public const SOLUTIONS = [318007, 9227661];
    public const EXAMPLE_SOLUTIONS = [[42, 42], [0, 0]];

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
        $ans1 = $this->execute($input, ['a' => 0, 'b' => 0, 'c' => 0, 'd' => 0])['a'] ?? 0;
        $ans2 = $this->execute($input, ['a' => 0, 'b' => 0, 'c' => 1, 'd' => 0])['a'] ?? 0;
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
            $a = explode(' ', $input[$pc]);
            switch ($a[0]) {
                case 'cpy':
                    if ((count($a) != 3) or !isset($registers[$a[2]])) {
                        throw new \Exception('Invalid instruction');
                    }
                    $registers[$a[2]] = $registers[$a[1]] ?? intval($a[1]);
                    break;
                case 'inc':
                    if ((count($a) != 2) or !isset($registers[$a[1]])) {
                        throw new \Exception('Invalid instruction');
                    }
                    ++$registers[$a[1]];
                    break;
                case 'dec':
                    if ((count($a) != 2) or !isset($registers[$a[1]])) {
                        throw new \Exception('Invalid instruction');
                    }
                    --$registers[$a[1]];
                    break;
                case 'jnz':
                    if (count($a) != 3) {
                        throw new \Exception('Invalid instruction');
                    }
                    if (($registers[$a[1]] ?? intval($a[1])) != 0) {
                        $pc += intval($a[2]) - 1;
                    }
                    break;
                default:
                    throw new \Exception('Invalid instruction');
            }
        }
    }
}

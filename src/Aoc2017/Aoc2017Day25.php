<?php

declare(strict_types=1);

namespace TBali\Aoc2017;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2017 Day 25: The Halting Problem.
 *
 * Part 1: Recreate the Turing machine and save the computer! What is the diagnostic checksum it produces
 *         once it's working again?
 * Part 2: N/A
 *
 * Topics: Turing machine
 *
 * @see https://adventofcode.com/2017/day/25
 */
final class Aoc2017Day25 extends SolutionBase
{
    public const YEAR = 2017;
    public const DAY = 25;
    public const TITLE = 'The Halting Problem';
    public const SOLUTIONS = [2832, 0];
    public const EXAMPLE_SOLUTIONS = [[3, 0]];

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
        $countStates = intdiv(count($input) - 2, 10);
        if (
            ($countStates < 2)
            or (count($input) != $countStates * 10 + 2)
            or !str_starts_with($input[0], 'Begin in state ')
            or !str_starts_with($input[1], 'Perform a diagnostic checksum after ')
            or (strlen($input[0]) != 17)
            or (strlen($input[1]) < 42)
        ) {
            throw new \Exception('Invalid input');
        }
        $startState = $input[0][15];
        $maxSteps = intval(explode(' step', substr($input[1], 36))[0]);
        $states = [];
        for ($i = 0; $i < $countStates; ++$i) {
            if (
                ($input[10 * $i + 2] != '')
                or !str_starts_with($input[10 * $i + 3], 'In state ')
                or (strlen($input[10 * $i + 3]) != 11)
                or ($input[10 * $i + 4] != '  If the current value is 0:')
                or !str_starts_with($input[10 * $i + 5], '    - Write the value ')
                or (strlen($input[10 * $i + 5]) != 24)
                or !str_starts_with($input[10 * $i + 6], '    - Move one slot to the ')
                or (strlen($input[10 * $i + 6]) < 32)
                or !str_starts_with($input[10 * $i + 7], '    - Continue with state ')
                or (strlen($input[10 * $i + 7]) != 28)
                or ($input[10 * $i + 8] != '  If the current value is 1:')
                or !str_starts_with($input[10 * $i + 9], '    - Write the value ')
                or (strlen($input[10 * $i + 9]) != 24)
                or !str_starts_with($input[10 * $i + 10], '    - Move one slot to the ')
                or (strlen($input[10 * $i + 10]) < 32)
                or !str_starts_with($input[10 * $i + 11], '    - Continue with state ')
                or (strlen($input[10 * $i + 11]) != 28)
            ) {
                throw new \Exception('Invalid input');
            }
            $state = $input[10 * $i + 3][9];
            $states[$state] =
                $input[10 * $i + 5][22] . $input[10 * $i + 6][27] . $input[10 * $i + 7][26]
                . $input[10 * $i + 9][22] . $input[10 * $i + 10][27] . $input[10 * $i + 11][26];
        }
        // ---------- Part 1
        $tape = [];
        $cursor = 0;
        $state = $startState;
        for ($step = 0; $step < $maxSteps; ++$step) {
            $slot = $tape[$cursor] ?? 0;
            $todo = $states[$state];
            $newSlot = ['0' => false, '1' => true][$todo[3 * $slot]] ?? throw new \Exception('Invalid input');
            if ($newSlot) {
                $tape[$cursor] = 1;
            } else {
                unset($tape[$cursor]);
            }
            $cursor += ['l' => -1, 'r' => 1][$todo[3 * $slot + 1]] ?? throw new \Exception('Invalid input');
            $state = $todo[3 * $slot + 2];
        }
        $ans1 = count($tape);
        return [strval($ans1), '0'];
    }
}

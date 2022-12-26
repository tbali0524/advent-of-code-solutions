<?php

declare(strict_types=1);

namespace TBali\Aoc2017;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2017 Day 8: I Heard You Like Registers.
 *
 * Part 1: What is the largest value in any register after completing the instructions in your puzzle input?
 * Part 2: To be safe, the CPU also needs to know the highest value held in any register during this process.
 *
 * Topics: assembly simulation
 *
 * @see https://adventofcode.com/2017/day/8
 */
final class Aoc2017Day08 extends SolutionBase
{
    public const YEAR = 2017;
    public const DAY = 8;
    public const TITLE = 'I Heard You Like Registers';
    public const SOLUTIONS = [4567, 5636];
    public const EXAMPLE_SOLUTIONS = [[1, 10]];

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
        $ans2 = 0;
        $max = 0;
        $regs = [];
        foreach ($input as $line) {
            $a = explode(' ', $line);
            if (count($a) != 7) {
                throw new \Exception('Invalid input');
            }
            $op1 = $regs[$a[4]] ?? 0;
            $op2 = intval($a[6]);
            $result = match ($a[5]) {
                '<' => $op1 < $op2,
                '>' => $op1 > $op2,
                '<=' => $op1 <= $op2,
                '>=' => $op1 >= $op2,
                '==' => $op1 == $op2,
                '!=' => $op1 != $op2,
                default => throw new \Exception('Invalid input'),
            };
            if (!$result) {
                continue;
            }
            $by = intval($a[2]);
            $regs[$a[0]] = match ($a[1]) {
                'inc' => ($regs[$a[0]] ?? 0) + $by,
                'dec' => ($regs[$a[0]] ?? 0) - $by,
                default => throw new \Exception('Invalid input'),
            };
            if ($regs[$a[0]] > $ans2) {
                $ans2 = $regs[$a[0]];
            }
        }
        $ans1 = intval(max($regs));
        return [strval($ans1), strval($ans2)];
    }
}

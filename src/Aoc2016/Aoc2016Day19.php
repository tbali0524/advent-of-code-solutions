<?php

declare(strict_types=1);

namespace TBali\Aoc2016;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2016 Day 19: An Elephant Named Joseph.
 *
 * Part 1: With the number of Elves given in your puzzle input, which Elf gets all the presents?
 * Part 2: With the number of Elves given in your puzzle input, which Elf now gets all the presents?
 *
 * Topics: Josephus problem, OEIS A006257
 *
 * @see https://adventofcode.com/2016/day/19
 */
final class Aoc2016Day19 extends SolutionBase
{
    public const YEAR = 2016;
    public const DAY = 19;
    public const TITLE = 'An Elephant Named Joseph';
    public const SOLUTIONS = [1841611, 1423634];
    public const STRING_INPUT = '3017957';
    public const EXAMPLE_SOLUTIONS = [[3, 2]];
    public const EXAMPLE_STRING_INPUTS = ['5', ''];

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
        $n = intval($input[0]);
        $ans1 = $this->josephus2($n);
        $ans2 = $this->solvePart2($n);
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @see https://en.wikipedia.org/wiki/Josephus_problem#k=2
     */
    private function josephus2(int $n): int
    {
        for ($i = 63; $i > 0; --$i) {
            if (($n & (1 << $i)) != 0) {
                break;
            }
        }
        return ~(1 << ($i + 1)) & (($n << 1) | 1);
    }

    private function solvePart2(int $n): int
    {
        $w = 1;
        for ($i = 1; $i < $n; ++$i) {
            $w = $w % $i + 1;
            if ($w > intdiv($i + 1, 2)) {
                ++$w;
            }
        }
        return $w;
    }
}

<?php

declare(strict_types=1);

namespace TBali\Aoc2020;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2020 Day 2: Password Philosophy.
 *
 * Part 1: How many passwords are valid according to their policies?
 * Part 2: How many passwords are valid according to the new interpretation of the policies?
 *
 * Topics: string validation
 *
 * @see https://adventofcode.com/2020/day/2
 */
final class Aoc2020Day02 extends SolutionBase
{
    public const YEAR = 2020;
    public const DAY = 2;
    public const TITLE = 'Password Philosophy';
    public const SOLUTIONS = [434, 509];
    public const EXAMPLE_SOLUTIONS = [[2, 1]];

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
        $ans1 = 0;
        foreach ($input as $line) {
            $a = explode(' ', $line);
            $a0 = explode('-', $a[0]);
            if ((count($a) != 3) or (count($a0) != 2)) {
                throw new \Exception('Invalid input');
            }
            $min = intval($a0[0]);
            $max = intval($a0[1]);
            $letter = $a[1][0];
            $pw = $a[2];
            $map = array_count_values(str_split($pw));
            if ((($map[$letter] ?? 0) >= $min) and (($map[$letter] ?? 0) <= $max)) {
                ++$ans1;
            }
        }
        // ---------- Part 2
        $ans2 = 0;
        foreach ($input as $line) {
            $a = explode(' ', $line);
            $a0 = explode('-', $a[0]);
            $pos1 = intval($a0[0]);
            $pos2 = intval($a0[1]);
            $letter = $a[1][0];
            $pw = $a[2];
            $count = ($pos1 <= strlen($pw)) && ($pw[$pos1 - 1] == $letter);
            $count += ($pos2 <= strlen($pw)) && ($pw[$pos2 - 1] == $letter);
            if ($count == 1) {
                ++$ans2;
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}

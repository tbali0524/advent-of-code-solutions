<?php

declare(strict_types=1);

namespace TBali\Aoc2025;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2025 Day 3: Lobby.
 *
 * @see https://adventofcode.com/2025/day/3
 */
final class Aoc2025Day03 extends SolutionBase
{
    public const YEAR = 2025;
    public const DAY = 3;
    public const TITLE = 'Lobby';
    public const SOLUTIONS = [17179, 170025781683941];
    public const EXAMPLE_SOLUTIONS = [[357, 3121910778619]];

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
        $ans1 = $this->solvePart($input, 2);
        $ans2 = $this->solvePart($input, 12);
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param array<int, string> $input The lines of the input, without LF
     */
    public function solvePart(array $input, int $count_digits): int
    {
        $ans = 0;
        foreach ($input as $bank) {
            $best = 0;
            $prev_pos_digit = 0;
            for ($i = 0; $i < $count_digits; ++$i) {
                $pos_digit = $prev_pos_digit;
                $digit = 0;
                for ($pos = $prev_pos_digit; $pos < strlen($bank) - ($count_digits - 1 - $i); ++$pos) {
                    $c = intval($bank[$pos]);
                    if ($c > $digit) {
                        $digit = $c;
                        $pos_digit = $pos;
                    }
                }
                $prev_pos_digit = $pos_digit + 1;
                $best = 10 * $best + $digit;
            }
            $ans += $best;
        }
        return $ans;
    }
}

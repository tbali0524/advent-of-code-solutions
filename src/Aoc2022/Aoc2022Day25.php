<?php

declare(strict_types=1);

namespace TBali\Aoc2022;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2022 Day 25: Full of Hot Air.
 *
 * Part 1: What SNAFU number do you supply to Bob's console?
 * Part 2: N/A
 *
 * Topics: balanced 5-ary numbers
 *
 * @see https://adventofcode.com/2022/day/25
 */
final class Aoc2022Day25 extends SolutionBase
{
    public const YEAR = 2022;
    public const DAY = 25;
    public const TITLE = 'Full of Hot Air';
    public const SOLUTIONS = ['20==1==12=0111=2--20', '0'];
    public const EXAMPLE_SOLUTIONS = [['2=-1=0', '0']];

    private const BASE = 5;
    private const DIGITS = '=-012';
    private const VALUES = ['=' => -2, '-' => -1, '0' => 0, '1' => 1, '2' => 2];

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
        $ans1 = self::toSnafu(array_sum(array_map(self::fromSnafu(...), $input)));
        return [strval($ans1), '0'];
    }

    private static function fromSnafu(string $s): int
    {
        $ans = 0;
        $base = 1;
        for ($i = strlen($s) - 1; $i >= 0; --$i) {
            $ans += $base * (self::VALUES[$s[$i]] ?? throw new \Exception('Invalid input'));
            $base *= self::BASE;
        }
        return $ans;
    }

    private static function toSnafu(int $n): string
    {
        if ($n == 0) {
            return '0';
        }
        $v = abs($n);
        $ans = '';
        $halfBase = intdiv(self::BASE - 1, 2);
        while ($v != 0) {
            $r = ($v + $halfBase) % self::BASE;
            $ans .= self::DIGITS[$r];
            if ($r < $halfBase) {
                $v += self::BASE;
            }
            $v = intdiv($v, self::BASE);
        }
        if ($n < 0) {
            $ans = strtr($ans, self::DIGITS, strrev(self::DIGITS));
        }
        return strrev($ans);
    }
}

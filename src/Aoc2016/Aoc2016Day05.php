<?php

declare(strict_types=1);

namespace TBali\Aoc2016;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2016 Day 5: How About a Nice Game of Chess?.
 *
 * Part 1: Given the actual Door ID, what is the password?
 * Part 2: Given the actual Door ID and this new method, what is the password?
 *
 * @see https://adventofcode.com/2016/day/5
 */
final class Aoc2016Day05 extends SolutionBase
{
    public const YEAR = 2016;
    public const DAY = 5;
    public const TITLE = 'How About a Nice Game of Chess?';
    public const SOLUTIONS = ['c6697b55', '8c35d1ab'];
    public const STRING_INPUT = 'ffykfhsq';
    public const EXAMPLE_SOLUTIONS = [['18f47a30', '05ace8e3'], [0, 0]];
    public const EXAMPLE_STRING_INPUTS = ['abc', ''];

    private const LEN = 8;

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
        $line = $input[0];
        // ---------- Part 1
        $ans1 = '';
        $idx = 0;
        for ($i = 0; $i < self::LEN; ++$i) {
            do {
                $hash = md5($line . strval($idx));
                ++$idx;
            } while (substr($hash, 0, 5) !== '00000');
            $ans1 .= $hash[5];
        }
        // ---------- Part 2
        $ans2 = str_repeat('-', self::LEN);
        $count = 0;
        $idx = 0;
        while ($count < self::LEN) {
            do {
                $hash = md5($line . strval($idx));
                ++$idx;
            } while (substr($hash, 0, 5) !== '00000');
            $pos = intval(hexdec($hash[5]));
            if (($pos < 0) or ($pos >= self::LEN) or ($ans2[$pos] != '-')) {
                continue;
            }
            $ans2[$pos] = $hash[6];
            ++$count;
        }
        return [$ans1, $ans2];
    }
}

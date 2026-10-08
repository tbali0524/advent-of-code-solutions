<?php

declare(strict_types=1);

namespace TBali\Aoc2023;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2023 Day 1: Trebuchet?!.
 *
 * Part 1: Consider your entire calibration document. What is the sum of all of the calibration values?
 * Part 2: What is the sum of all of the calibration values?
 *
 * @see https://adventofcode.com/2023/day/1
 */
final class Aoc2023Day01 extends SolutionBase
{
    public const YEAR = 2023;
    public const DAY = 1;
    public const TITLE = 'Trebuchet?!';
    public const SOLUTIONS = [56108, 55652];
    public const EXAMPLE_SOLUTIONS = [[142, 0], [0, 281]];

    public const SPELLINGS = [
        1 => 'one',
        2 => 'two',
        3 => 'three',
        4 => 'four',
        5 => 'five',
        6 => 'six',
        7 => 'seven',
        8 => 'eight',
        9 => 'nine',
        // 83 => 'eighthree',
        // 79 => 'sevenine',
        // 18 => 'oneight',
    ];

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
        $fnDigits = static fn (array $a): array => array_map(
            static fn (string $s): string => implode('', array_filter(
                str_split($s),
                static fn (string $c): bool => $c >= '0' && $c <= '9',
            )),
            $a,
        );
        $fnSumBorder = static fn (array $a): int => array_sum(array_map(
            static fn (string $s): int => 10 * intval($s[0] ?? '0') + intval($s[-1] ?? '0'),
            $a,
        ));
        $ans1 = $fnSumBorder($fnDigits($input));
        $replaced = [];
        foreach ($input as $line) {
            $s = $line;
            for ($i = 0; $i < strlen($line); ++$i) {
                foreach (self::SPELLINGS as $value => $spelling) {
                    if (substr($s, $i, strlen($spelling)) === $spelling) {
                        $s = substr($s, 0, $i) . strval($value) . substr($s, $i + 1);
                        break;
                    }
                }
            }
            $replaced[] = $s;
        }
        $ans2 = $fnSumBorder($fnDigits($replaced));
        return [strval($ans1), strval($ans2)];
    }
}

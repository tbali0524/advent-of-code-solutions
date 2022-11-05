<?php

declare(strict_types=1);

namespace TBali\Aoc2017;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2017 Day 1: Inverse Captcha.
 *
 * Part 1: What is the solution to your captcha?
 * Part 2: What is the solution to your new captcha?
 *
 * @see https://adventofcode.com/2017/day/1
 */
final class Aoc2017Day01 extends SolutionBase
{
    public const YEAR = 2017;
    public const DAY = 1;
    public const TITLE = 'Inverse Captcha';
    public const SOLUTIONS = [1102, 1076];
    public const EXAMPLE_SOLUTIONS = [[9, 0], [0, 4]];
    public const EXAMPLE_STRING_INPUTS = ['91212129', '12131415'];

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
        $line = $input[0] ?? '';
        // ---------- Part 1
        $ans1 = 0;
        for ($i = 0; $i < strlen($line); ++$i) {
            if ($line[$i] == $line[($i + 1) % strlen($line)]) {
                $ans1 += intval($line[$i]);
            }
        }
        // ---------- Part 2
        $ans2 = 0;
        for ($i = 0; $i < strlen($line); ++$i) {
            if ($line[$i] == $line[($i + intdiv(strlen($line), 2)) % strlen($line)]) {
                $ans2 += intval($line[$i]);
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}

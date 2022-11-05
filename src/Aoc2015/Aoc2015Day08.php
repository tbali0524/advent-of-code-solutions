<?php

declare(strict_types=1);

namespace TBali\Aoc2015;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2015 Day 8: Matchsticks.
 *
 * Part 1: Disregarding the whitespace in the file, what is the number of characters of code for string literals
 *         minus the number of characters in memory for the values of the strings in total for the entire file?
 * Part 2: Your task is to find the total number of characters to represent the newly encoded strings
 *         minus the number of characters of code in each original string literal.
 *
 * @see https://adventofcode.com/2015/day/8
 */
final class Aoc2015Day08 extends SolutionBase
{
    public const YEAR = 2015;
    public const DAY = 8;
    public const TITLE = 'Matchsticks';
    public const SOLUTIONS = [1371, 2117];
    public const EXAMPLE_SOLUTIONS = [[12, 19], [0, 0]];

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
            $ans1 += strlen($line);
            $i = 0;
            while ($i < strlen($line) - 2) {
                ++$i;
                --$ans1;
                if ($line[$i] == '\\') {
                    if (($line[$i + 1] == '\\') or ($line[$i + 1] == '"')) {
                        ++$i;
                        continue;
                    }
                    if ($line[$i + 1] == 'x') {
                        $i += 3;
                        continue;
                    }
                }
            }
        }
        // ---------- Part 2
        $ans2 = 0;
        foreach ($input as $line) {
            $ans2 += substr_count($line, '"') + substr_count($line, '\\') + 2;
        }
        return [strval($ans1), strval($ans2)];
    }
}

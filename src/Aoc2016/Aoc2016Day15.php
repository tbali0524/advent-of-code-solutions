<?php

declare(strict_types=1);

namespace TBali\Aoc2016;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2016 Day 15: Timing is Everything.
 *
 * Part 1: What is the first time you can press the button to get a capsule?
 * Part 2: With this new disc, and counting again starting from time=0 with the configuration in your puzzle input,
 *         what is the first time you can press the button to get another capsule?
 *
 * Topics: Chinese Remainder Theorem
 *
 * @see https://adventofcode.com/2016/day/15
 */
final class Aoc2016Day15 extends SolutionBase
{
    public const YEAR = 2016;
    public const DAY = 15;
    public const TITLE = 'Timing is Everything';
    public const SOLUTIONS = [317371, 2080951];
    public const EXAMPLE_SOLUTIONS = [[5, 0]];

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
        // ---------- Process input
        $discs = [];
        foreach ($input as $line) {
            $a = explode(' ', $line);
            if (count($a) != 12) {
                throw new \Exception('Invalid input');
            }
            $id = intval(substr($a[1], 1));
            $modulo = intval($a[3]);
            $time = intval(substr($a[6], 5, -1));
            $position = intval(substr($a[11], 0, -1));
            $remainder = ($time - $position - $id) % $modulo;
            $discs[$modulo] = $remainder >= 0 ? $remainder : $remainder + $modulo;
        }
        // ---------- Part 1
        $ans1 = $this->solvePart($discs);
        // ---------- Part 2
        $id = count($input) + 1;
        $modulo = 11;
        $time = 0;
        $position = 0;
        $remainder = ($time - $position - $id) % $modulo;
        $discs[$modulo] = $remainder >= 0 ? $remainder : $remainder + $modulo;
        $ans2 = $this->solvePart($discs);
        return [strval($ans1), strval($ans2)];
    }

    /**
     * Solve system of congruences.
     *
     * @see https://en.wikipedia.org/wiki/Chinese_remainder_theorem#Search_by_sieving
     *
     * @param array<int, int> $discs
     */
    private function solvePart(array $discs): int
    {
        if (count($discs) == 0) {
            return 0;
        }
        krsort($discs);
        $step = array_key_first($discs);
        $from = $discs[$step];
        $cand = -1;
        foreach ($discs as $mod => $rem) {
            if ($cand < 0) {
                $cand = 0;
                continue;
            }
            $cand = $from;
            while (true) {
                if ($cand % $mod == $rem) {
                    break;
                }
                $cand += $step;
            }
            $from = $cand;
            $step *= $mod;
        }
        return $cand;
    }
}

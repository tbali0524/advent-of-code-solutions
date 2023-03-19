<?php

declare(strict_types=1);

namespace TBali\Aoc2021;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2021 Day 3: Binary Diagnostic.
 *
 * Part 1: What is the power consumption of the submarine?
 * Part 2: What is the life support rating of the submarine?
 *
 * @see https://adventofcode.com/2021/day/3
 */
final class Aoc2021Day03 extends SolutionBase
{
    public const YEAR = 2021;
    public const DAY = 3;
    public const TITLE = 'Binary Diagnostic';
    public const SOLUTIONS = [3813416, 2990784];
    public const EXAMPLE_SOLUTIONS = [[198, 230]];

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
        // ---------- Parse input
        $countBits = strlen($input[0]);
        /** @var array<int, int> */
        $startNumbers = array_map(bindec(...), $input);
        // ---------- Part 1
        $gamma = 0;
        for ($pos = 0; $pos < $countBits; ++$pos) {
            $gamma |= ($this->mostCommonBit($startNumbers, $countBits, $pos) << $pos);
        }
        $ans1 = $gamma * ((1 << $countBits) - 1 - $gamma);
        // ---------- Part 2
        $numbers = $startNumbers;
        $pos = $countBits;
        while (true) {
            --$pos;
            if ($pos < 0) {
                break;
            }
            if (count($numbers) <= 1) {
                break;
            }
            $target = $this->mostCommonBit($numbers, $countBits, $pos);
            $numbers = array_filter($numbers, fn (int $x): bool => (($x >> $pos) & 1) == $target);
        }
        if (count($numbers) != 1) {
            throw new \Exception('Invalid input');
        }
        $oxygen = array_values($numbers)[0];
        $numbers = $startNumbers;
        $pos = $countBits;
        while (true) {
            --$pos;
            if ($pos < 0) {
                break;
            }
            if (count($numbers) <= 1) {
                break;
            }
            $target = 1 - $this->mostCommonBit($numbers, $countBits, $pos);
            $numbers = array_filter($numbers, fn (int $x): bool => (($x >> $pos) & 1) == $target);
        }
        if (count($numbers) != 1) {
            throw new \Exception('Invalid input');
        }
        $co2 = array_values($numbers)[0];
        $ans2 = $oxygen * $co2;
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param array<int, int> $numbers
     */
    private function mostCommonBit(array $numbers, int $countBits, int $pos): int
    {
        $countOnes = 0;
        foreach ($numbers as $n) {
            if ((($n >> $pos) & 1) == 1) {
                ++$countOnes;
            }
        }
        return 2 * $countOnes >= count($numbers) ? 1 : 0;
    }
}

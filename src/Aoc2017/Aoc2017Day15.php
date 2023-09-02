<?php

declare(strict_types=1);

namespace TBali\Aoc2017;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2017 Day 15: Dueling Generators.
 *
 * Part 1: After 40 million pairs, what is the judge's final count?
 * Part 2: After 5 million pairs, but using this new generator logic, what is the judge's final count?
 *
 * @see https://adventofcode.com/2017/day/15
 */
final class Aoc2017Day15 extends SolutionBase
{
    public const YEAR = 2017;
    public const DAY = 15;
    public const TITLE = 'Dueling Generators';
    public const SOLUTIONS = [650, 336];
    public const EXAMPLE_SOLUTIONS = [[588, 309]];

    private const MAX_STEPS_PART1 = 40_000_000;
    private const MAX_STEPS_PART2 = 5_000_000;
    private const MULTIPLIER_A = 16807;
    private const MULTIPLIER_B = 48271;
    private const MODULUS = 2147483647;

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
        if (!str_starts_with($input[0] ?? '', 'Generator ') or !str_starts_with($input[1] ?? '', 'Generator ')) {
            throw new \Exception('Invalid input');
        }
        $startA = intval(substr($input[0], 24));
        $startB = intval(substr($input[1], 24));
        // ---------- Part 1
        $ans1 = 0;
        $a = $startA;
        $b = $startB;
        for ($step = 0; $step < self::MAX_STEPS_PART1; ++$step) {
            $a = ($a * self::MULTIPLIER_A) % self::MODULUS;
            $b = ($b * self::MULTIPLIER_B) % self::MODULUS;
            if (($a & 0xFFFF) == ($b & 0xFFFF)) {
                ++$ans1;
            }
        }
        // ---------- Part 2
        $ans2 = 0;
        $a = $startA;
        $b = $startB;
        for ($step = 0; $step < self::MAX_STEPS_PART2; ++$step) {
            do {
                $a = ($a * self::MULTIPLIER_A) % self::MODULUS;
            } while (($a & 0b11) != 0);
            do {
                $b = ($b * self::MULTIPLIER_B) % self::MODULUS;
            } while (($b & 0b111) != 0);
            if (($a & 0xFFFF) == ($b & 0xFFFF)) {
                ++$ans2;
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}

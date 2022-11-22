<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2015;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2015 Day 20: Infinite Elves and Infinite Houses.
 *
 * Part 1: What is the lowest house number of the house to get at least as many presents as the number
 *         in your puzzle input?
 * Part 2: With these changes, what is the new lowest house number of the house to get at least as many presents
 *         as the number in your puzzle input?
 *
 * Topics: prime factorization, sigma function, sum-of-divisors function, OEIS A000203
 *
 * @see https://adventofcode.com/2015/day/20
 */
final class Aoc2015Day20 extends SolutionBase
{
    public const YEAR = 2015;
    public const DAY = 20;
    public const TITLE = 'Infinite Elves and Infinite Houses';
    public const SOLUTIONS = [831600, 884520];
    public const STRING_INPUT = '36000000';
    public const EXAMPLE_SOLUTIONS = [[8, 0], [6, 0]];
    public const EXAMPLE_STRING_INPUTS = ['150', '120'];

    private const MAX_PART2 = 50;

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
        $input = intval($input[0]);
        // ---------- Part 1
        $n = intdiv($input, 10);
        $h = array_fill(0, $n, 0);
        for ($i = 1; $i < $n; ++$i) {
            for ($j = $i; $j < $n; $j += $i) {
                $h[$j] += $i;
            }
        }
        $i = 1;
        while ($h[$i] < $n) {
            ++$i;
        }
        $ans1 = $i;
        // ---------- Part 2
        $n = intdiv($input, 11);
        $h = array_fill(0, $n, 0);
        for ($i = 1; $i < $n; ++$i) {
            $count = 0;
            for ($j = $i; $j < $n; $j += $i) {
                $h[$j] += $i;
                ++$count;
                if ($count == self::MAX_PART2) {
                    break;
                }
            }
        }
        $i = 1;
        while ($h[$i] < $n) {
            ++$i;
        }
        $ans2 = $i;
        return [strval($ans1), strval($ans2)];
    }
}

// --------------------------------------------------------------------
// not used in the puzzle (would be too slow)
final class PrimeFactors
{
    public readonly int $n;
    /** @var array<int, int> */
    public array $factorExp = [];   // base => exp

    public function __construct(int $n)
    {
        $this->n = $n;
        while ($n % 2 == 0) {
            $this->addFactor(2);
            $n = intdiv($n, 2);
        }
        $i = 3;
        while ($n > 1) {
            while ($n % $i == 0) {
                $this->addFactor($i);
                $n = intdiv($n, $i);
            }
            $i += 2;
        }
    }

    // sigma function, https://en.wikipedia.org/wiki/Divisor_function#Formulas_at_prime_powers
    public function sumOfDivisors(): int
    {
        $ans = 1;
        foreach ($this->factorExp as $base => $exp) {
            $ans *= ($base ** ($exp + 1) - 1) / ($base - 1);
        }
        return intval(round($ans));
    }

    private function addFactor(int $p): void
    {
        if (isset($this->factorExp[$p])) {
            ++$this->factorExp[$p];
        } else {
            $this->factorExp[$p] = 1;
        }
    }
}

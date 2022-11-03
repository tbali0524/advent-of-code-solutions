<?php

// @TODO part 1 too slow

/*
https://adventofcode.com/2015/day/20
Part 1: What is the lowest house number of the house to get at least as many presents as the number
    in your puzzle input?
Part 2:
*/

// phpcs:disable PSR1.Classes.ClassDeclaration

declare(strict_types=1);

namespace TBali\Aoc2015;

use TBali\Aoc\SolutionBase;

final class Aoc2015Day20 extends SolutionBase
{
    public const YEAR = 2015;
    public const DAY = 20;
    public const TITLE = 'Infinite Elves and Infinite Houses';
    public const SOLUTIONS = [0, 0];
    public const STRING_INPUT = '36000000';
    public const EXAMPLE_SOLUTIONS = [[0, 0], [0, 0]];

    /**
     * @param string[] $input
     *
     * @return array{string, string}
     */
    public function solve(array $input): array
    {
        $input = intval($input[0]);
        // ---------- Part 1
        $ans1 = 1;
        $min = intval((-1 + sqrt(1 + 8 * $input / 10)) / 2);
        $max = intval(ceil($input / 10));
        for ($n = $min; $n <= $max; ++$n) {
            $sum = (new PrimeFactors($n))->sumOfDivisors();
            // $sum = 1 + $n;
            // for ($i = 2; $i <= intdiv($n, 2); ++$i) {
            //     if ($n % $i == 0) {
            //         $sum += $i;
            //     }
            // }
            if (10 * $sum >= $input) {
                $ans1 = $n;
                break;
            }
        }
        // ---------- Part 2
        $ans2 = 0;
        return [strval($ans1), strval($ans2)];
    }
}

// --------------------------------------------------------------------
final class PrimeFactors
{
    public readonly int $n;
    /** @var array<int, int> */
    public array $factorExp = [];   // baes => exp

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

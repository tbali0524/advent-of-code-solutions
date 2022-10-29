<?php

// @TODO part 1 too slow

/*
https://adventofcode.com/2015/day/20
Part 1: What is the lowest house number of the house to get at least as many presents as the number
    in your puzzle input?
Part 2:
*/

// phpcs:disable PSR1.Files.SideEffects, PSR1.Classes.ClassDeclaration

declare(strict_types=1);

namespace TBali\Aoc15_20;

// --------------------------------------------------------------------
const YEAR = 2015;
const DAY = '20';
const TITLE = 'Infinite Elves and Infinite Houses';
const SOLUTION1 = 0;
const SOLUTION2 = 0;
$startTime = hrtime(true);
// ----------
$input = 36000000;
// --------------------------------------------------------------------
// Part 1
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
// --------------------------------------------------------------------
// Part 2
$ans2 = 1;
// ----------
$spentTime = number_format((hrtime(true) - $startTime) / 1000_000_000, 4, '.', '');
$maxMemory = strval(ceil(memory_get_peak_usage(true) / 1000_000));
echo '=== AoC ' . YEAR . ' Day ' . DAY . ' [time: ' . $spentTime . ' sec, memory: ' . $maxMemory . ' MB]: ' . TITLE
    . PHP_EOL;
echo $ans1, PHP_EOL;
if ($ans1 != SOLUTION1) {
    echo '*** WRONG ***', PHP_EOL;
}
echo $ans2, PHP_EOL;
// @phpstan-ignore-next-line
if ($ans2 != SOLUTION2) {
    echo '*** WRONG ***', PHP_EOL;
}
// --------------------------------------------------------------------
class PrimeFactors
{
    public int $n;
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

    private function addFactor(int $p): void
    {
        if (isset($this->factorExp[$p])) {
            ++$this->factorExp[$p];
        } else {
            $this->factorExp[$p] = 1;
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
}

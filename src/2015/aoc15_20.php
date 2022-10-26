<?php

// @TODO nem működik

/*
https://adventofcode.com/2015/day/20
Part 1: What is the lowest house number of the house to get at least as many presents as the number
    in your puzzle input?
Part 2:
*/

declare(strict_types=1);

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
$max = intval(ceil($input / 10));
for ($n = 2; $n <= $max; ++$n) {
    $sum = 1 + $n;
    for ($i = 2; $i <= intdiv($n, 2); ++$i) {
        if ($n % $i == 0) {
            $sum += $i;
        }
    }
    if ($sum >= $input) {
        $ans1 = $n;
        break;
    }
}
// --------------------------------------------------------------------
// Part 2
$ans2 = 1;
while (substr(md5($input . strval($ans2)), 0, 6) !== '000000') {
    ++$ans2;
}
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
if ($ans2 != SOLUTION2) {
    echo '*** WRONG ***', PHP_EOL;
}

<?php

/*
https://adventofcode.com/2019/day/1
Part 1: What is the sum of the fuel requirements for all of the modules on your spacecraft?
Part 2: What is the sum of the fuel requirements for all of the modules on your spacecraft when also
    taking into account the mass of the added fuel?
*/

declare(strict_types=1);

// --------------------------------------------------------------------
const YEAR = 2019;
const DAY = '01';
const TITLE = 'The Tyranny of the Rocket Equation';
const SOLUTION1 = 3287620;
const SOLUTION2 = 4928567;
$startTime = hrtime(true);
// ----------
$handle = fopen('input/' . YEAR . '/aoc19_01.txt', 'r');
if ($handle === false) {
    throw new \Exception('Cannot load input file');
}
$input = [];
while (true) {
    $line = fgets($handle);
    if ($line === false) {
        break;
    }
    if (trim($line) == '') {
        continue;
    }
    $input[] = intval(trim($line));
}
fclose($handle);
// --------------------------------------------------------------------
// Part 1
$ans1 = array_sum(array_map(
    fn ($x) => intdiv($x, 3) - 2,
    $input
));
// --------------------------------------------------------------------
// Part 2
$ans2 = 0;
foreach ($input as $mass) {
    $total = 0;
    $fuel = $mass;
    while (true) {
        $fuel = max(0, intdiv($fuel, 3) - 2);
        $total += $fuel;
        if ($fuel == 0) {
            break;
        }
    }
    $ans2 += $total;
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

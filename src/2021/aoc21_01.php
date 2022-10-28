<?php

/*
https://adventofcode.com/2020/day/1
Part 1: How many measurements are larger than the previous measurement?
Part 2: Consider sums of a three-measurement sliding window. How many sums are larger than the previous sum?
*/

declare(strict_types=1);

// --------------------------------------------------------------------
const YEAR = 2021;
const DAY = '01';
const TITLE = 'Sonar Sweep';
const SOLUTION1 = 1477;
const SOLUTION2 = 1523;
$startTime = hrtime(true);
// ----------
$handle = fopen('input/' . YEAR . '/aoc21_01.txt', 'r');
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
$ans1 = 0;
for ($i = 1; $i < count($input); ++$i) {
    if ($input[$i] > $input[$i - 1]) {
        ++$ans1;
    }
}
// --------------------------------------------------------------------
// Part 2
$ans2 = 0;
const WINDOW = 3;
for ($i = WINDOW; $i < count($input); ++$i) {
    if ($input[$i] > $input[$i - WINDOW]) {
        ++$ans2;
    }
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

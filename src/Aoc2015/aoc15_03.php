<?php

/*
https://adventofcode.com/2015/day/3
Part 1: How many houses receive at least one present?
Part 2: This year, how many houses receive at least one present?
*/

declare(strict_types=1);

// --------------------------------------------------------------------
const YEAR = 2015;
const DAY = '03';
const TITLE = 'Perfectly Spherical Houses in a Vacuum';
const SOLUTION1 = 2592;
const SOLUTION2 = 2360;
$startTime = hrtime(true);
// ----------
$handle = fopen('input/' . YEAR . '/aoc15_03.txt', 'r');
if ($handle === false) {
    throw new \Exception('Cannot load input file');
}
$input = '';
while (true) {
    $line = fgets($handle);
    if ($line === false) {
        break;
    }
    if (trim($line) == '') {
        continue;
    }
    $input = trim($line);
}
fclose($handle);
// --------------------------------------------------------------------
// Part 1
$ans1 = 1;
const DELTAS = ['>' => [1, 0], 'v' => [0, 1], '<' => [-1, 0], '^' => [0, -1]];
$memo = [];
$x = 0;
$y = 0;
$memo[$y][$x] = 1;
foreach (str_split($input) as $dir) {
    [$dx, $dy] = DELTAS[$dir] ?? [0, 0];
    $x += $dx;
    $y += $dy;
    if (!isset($memo[$y][$x])) {
        ++$ans1;
    }
    $memo[$y][$x] = 1;
}
// --------------------------------------------------------------------
// Part 2
$ans2 = 1;
$memo = [];
$x = [0, 0];
$y = [0, 0];
$memo[$y[0]][$x[0]] = 1;
foreach (str_split($input) as $idx => $dir) {
    [$dx, $dy] = DELTAS[$dir] ?? [0, 0];
    $x[$idx % 2] += $dx;
    $y[$idx % 2] += $dy;
    if (!isset($memo[$y[$idx % 2]][$x[$idx % 2]])) {
        ++$ans2;
    }
    $memo[$y[$idx % 2]][$x[$idx % 2]] = 1;
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

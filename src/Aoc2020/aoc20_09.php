<?php

/*
https://adventofcode.com/2020/day/9
Part 1: What is the first number that does not have this property?
Part 2: What is the encryption weakness in your XMAS-encrypted list of numbers?
*/

declare(strict_types=1);

// --------------------------------------------------------------------
const YEAR = 2020;
const DAY = '09';
const TITLE = 'Encoding Error';
const SOLUTION1 = 466456641;
const SOLUTION2 = 55732936;
$startTime = hrtime(true);
// ----------
$handle = fopen('input/' . YEAR . '/aoc20_09.txt', 'r');
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
    $input[] = intval($line);
}
fclose($handle);
// --------------------------------------------------------------------
// Part 1
$ans1 = 0;
const WINDOW = 25;
if (count($input) < WINDOW) {
    throw new \Exception('Invalid input');
}
$memo = [];
for ($i = 0; $i < WINDOW; ++$i) {
    for ($j = $i + 1; $j < WINDOW; ++$j) {
        $memo[$input[$i] + $input[$j]] = $i;
    }
}
for ($i = WINDOW; $i < count($input); ++$i) {
    $item = $input[$i];
    if (!isset($memo[$item]) or ($i - $memo[$item] > WINDOW)) {
        $ans1 = $item;
        break;
    }
    for ($j = $i - WINDOW + 1; $j < $i; ++$j) {
        $memo[$item + $input[$j]] = max($memo[$item + $input[$j]] ?? 0, $j);
    }
}
// --------------------------------------------------------------------
// Part 2
$ans2 = 0;
$from = 0;
$to = 1;
$sum = $input[$from] + $input[$to];
while (true) {
    if ($sum == $ans1) {
        break;
    }
    while (($sum < $ans1) and ($to < count($input))) {
        ++$to;
        $sum += $input[$to];
    }
    if ($to >= count($input)) {
        throw new \Exception('No solution found');
    }
    if ($sum == $ans1) {
        break;
    }
    while (($sum > $ans1) and ($from < $to)) {
        $sum -= $input[$from];
        ++$from;
    }
    if ($sum == $ans1) {
        break;
    }
    if ($from == $to) {
        ++$from;
        $to = $from + 1;
        $sum = $input[$from] + $input[$to];
    }
}
$slice = array_slice($input, $from, $to - $from + 1);
$ans2 = min($slice) + max($slice);
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

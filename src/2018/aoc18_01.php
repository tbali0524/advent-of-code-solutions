<?php

/*
https://adventofcode.com/2018/day/1
Part 1: What is the resulting frequency after all of the changes in frequency have been applied?
Part 2: What is the first frequency your device reaches twice?
*/

declare(strict_types=1);

// --------------------------------------------------------------------
const YEAR = 2018;
const DAY = '01';
const TITLE = 'Chronal Calibration';
const SOLUTION1 = 590;
const SOLUTION2 = 83445;
$startTime = hrtime(true);
// ----------
$handle = fopen('input/' . YEAR . '/aoc18_01.txt', 'r');
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
$ans1 = array_sum($input);
// --------------------------------------------------------------------
// Part 2
$ans2 = 0;
$memo = [];
$freq = 0;
while (true) {
    foreach ($input as $delta) {
        $freq += $delta;
        if (isset($memo[$freq])) {
            $ans2 = $freq;
            break 2;
        }
        $memo[$freq] = true;
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

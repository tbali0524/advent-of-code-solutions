<?php

/*
https://adventofcode.com/2017/day/1
Part 1: What is the solution to your captcha?
Part 2: What is the solution to your new captcha?
*/

declare(strict_types=1);

// --------------------------------------------------------------------
const YEAR = 2017;
const DAY = '01';
const TITLE = 'Inverse Captcha';
const SOLUTION1 = 1102;
const SOLUTION2 = 1076;
$startTime = hrtime(true);
// ----------
$handle = fopen('input/' . YEAR . '/aoc17_01.txt', 'r');
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
$ans1 = 0;
for ($i = 0; $i < strlen($input); ++$i) {
    if ($input[$i] == $input[($i + 1) % strlen($input)]) {
        $ans1 += intval($input[$i]);
    }
}
// --------------------------------------------------------------------
// Part 2
$ans2 = 0;
for ($i = 0; $i < strlen($input); ++$i) {
    if ($input[$i] == $input[($i + intdiv(strlen($input), 2)) % strlen($input)]) {
        $ans2 += intval($input[$i]);
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

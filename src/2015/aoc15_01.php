<?php

/*
https://adventofcode.com/2015/day/1
Part 1: To what floor do the instructions take Santa?
Part 2: What is the position of the character that causes Santa to first enter the basement?
*/

declare(strict_types=1);

// --------------------------------------------------------------------
const YEAR = 2015;
const DAY = '01';
const TITLE = 'Not Quite Lisp';
const SOLUTION1 = 74;
const SOLUTION2 = 1795;
$startTime = hrtime(true);
// ----------
$handle = fopen('input/' . YEAR . '/aoc15_01.txt', 'r');
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
$ans1 = substr_count($input, '(') - substr_count($input, ')');
// --------------------------------------------------------------------
// Part 2
$ans2 = 0;
$floor = 0;
while ($ans2 < strlen($input) and ($floor >= 0)) {
    if ($input[$ans2] == '(') {
        ++$floor;
    } elseif ($input[$ans2] == ')') {
        --$floor;
    }
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

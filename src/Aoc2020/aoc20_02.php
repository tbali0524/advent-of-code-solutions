<?php

/*
https://adventofcode.com/2020/day/2
Part 1: How many passwords are valid according to their policies?
Part 2: How many passwords are valid according to the new interpretation of the policies?
*/

declare(strict_types=1);

// --------------------------------------------------------------------
const YEAR = 2020;
const DAY = '02';
const TITLE = 'Password Philosophy';
const SOLUTION1 = 434;
const SOLUTION2 = 509;
$startTime = hrtime(true);
// ----------
$handle = fopen('input/' . YEAR . '/aoc20_02.txt', 'r');
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
    $input[] = trim($line);
}
fclose($handle);
// --------------------------------------------------------------------
// Part 1
$ans1 = 0;
foreach ($input as $line) {
    $a = explode(' ', $line);
    $a0 = explode('-', $a[0]);
    if ((count($a) != 3) or (count($a0) != 2)) {
        throw new \Exception('Invalid input');
    }
    $min = intval($a0[0]);
    $max = intval($a0[1]);
    $letter = $a[1][0];
    $pw = $a[2];
    $map = array_count_values(str_split($pw));
    if ((($map[$letter] ?? 0) >= $min) and (($map[$letter] ?? 0) <= $max)) {
        ++$ans1;
    }
}
// --------------------------------------------------------------------
// Part 2
$ans2 = 0;
foreach ($input as $line) {
    $a = explode(' ', $line);
    $a0 = explode('-', $a[0]);
    if ((count($a) != 3) or (count($a0) != 2)) {
        throw new \Exception('Invalid input');
    }
    $pos1 = intval($a0[0]);
    $pos2 = intval($a0[1]);
    $letter = $a[1][0];
    $pw = $a[2];
    $count = ($pos1 <= strlen($pw)) && ($pw[$pos1 - 1] == $letter);
    $count += ($pos2 <= strlen($pw)) && ($pw[$pos2 - 1] == $letter);
    if ($count == 1) {
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

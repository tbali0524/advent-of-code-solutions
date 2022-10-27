<?php

/*
https://adventofcode.com/2015/day/25
Part 1: What code do you give the machine?
Part 2:
*/

// phpcs:disable PSR1.Files.SideEffects

declare(strict_types=1);

// --------------------------------------------------------------------
const YEAR = 2015;
const DAY = '25';
const TITLE = 'Let It Snow';
const SOLUTION1 = 19980801;
const SOLUTION2 = 0;
$startTime = hrtime(true);
// ----------
$handle = fopen('input/' . YEAR . '/aoc15_25.txt', 'r');
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
$a = explode(' ', $input[0]);
if (count($a) != 19) {
    throw new \Exception('Invalid input');
}
$row = intval(substr($a[16], 0, -1));
$column = intval(substr($a[18], 0, -1));
$n = $row + $column - 2;
$n = intdiv($n * ($n + 1), 2) + $column - 1;
$ans1 = getPassword(20151125, $n);
// --------------------------------------------------------------------
// Part 2
$ans2 = 0;
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
function getPassword(int $start, int $steps = 1): int
{
    $pw = $start;
    for ($i = 0; $i < $steps; ++$i) {
        $pw = ($pw * 252533) % 33554393;
    }
    return $pw;
}

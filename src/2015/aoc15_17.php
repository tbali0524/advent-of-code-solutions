<?php

/*
https://adventofcode.com/2015/day/17
Part 1: How many different combinations of containers can exactly fit all 150 liters of eggnog?
Part 2: Find the minimum number of containers that can exactly fit all 150 liters of eggnog.
    How many different ways can you fill that number of containers and still hold exactly 150 litres?
topics: combinations
*/

declare(strict_types=1);

// --------------------------------------------------------------------
const YEAR = 2015;
const DAY = '17';
const TITLE = 'No Such Thing as Too Much';
const SOLUTION1 = 1304;
const SOLUTION2 = 18;
$startTime = hrtime(true);
// ----------
$handle = fopen('input/' . YEAR . '/aoc15_17.txt', 'r');
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
// Part 1 + 2
$ans1 = 0;
const TOTAL = 150;
rsort($input);
$counts = array_fill(0, count($input), 0);
echo 1 << count($input), PHP_EOL;
for ($i = 0; $i < (1 << count($input)); ++$i) {
    $n = $i;
    $pos = 0;
    $sum = 0;
    $bits = 0;
    while (($n > 0) and ($sum < TOTAL)) {
        if (($n & 1) != 0) {
            $sum += $input[$pos];
            ++$bits;
        }
        ++$pos;
        $n >>= 1;
    }
    if (($n == 0) and ($sum == TOTAL)) {
        ++$ans1;
        ++$counts[$bits];
    }
}
$i = 0;
while (($i < count($counts) - 1) and ($counts[$i] == 0)) {
    ++$i;
}
$ans2 = $counts[$i];
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

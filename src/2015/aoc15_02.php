<?php

/*
https://adventofcode.com/2015/day/2
Part 1: How many total square feet of wrapping paper should they order?
Part 2: How many total feet of ribbon should they order?
*/

declare(strict_types=1);

// --------------------------------------------------------------------
const YEAR = 2015;
const DAY = '02';
const TITLE = 'I Was Told There Would Be No Math';
const SOLUTION1 = 1606483;
const SOLUTION2 = 3842356;
$startTime = hrtime(true);
// ----------
$handle = fopen('input/' . YEAR . '/aoc15_02.txt', 'r');
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
    $input[] = array_map('intval', explode('x', trim($line)));
}
fclose($handle);
// --------------------------------------------------------------------
// Part 1
$ans1 = 0;
foreach ($input as $box) {
    if (count($box) != 3) {
        throw new \Exception('Invalid input');
    }
    $sides = [];
    $sides[] = $box[0] * $box[1];
    $sides[] = $box[0] * $box[2];
    $sides[] = $box[1] * $box[2];
    $ans1 += 2 * array_sum($sides) + min($sides);
}
// --------------------------------------------------------------------
// Part 2
$ans2 = 0;
foreach ($input as $box) {
    if (count($box) != 3) {
        throw new \Exception('Invalid input');
    }
    sort($box);
    $ans2 += 2 * ($box[0] + $box[1]) + array_product($box);
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

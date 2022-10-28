<?php

/*
https://adventofcode.com/2020/day/5
Part 1: What is the highest seat ID on a boarding pass?
Part 2: What is the ID of your seat?
*/

declare(strict_types=1);

// --------------------------------------------------------------------
const YEAR = 2020;
const DAY = '05';
const TITLE = 'Binary Boarding';
const SOLUTION1 = 894;
const SOLUTION2 = 579;
$startTime = hrtime(true);
// ----------
$handle = fopen('input/' . YEAR . '/aoc20_05.txt', 'r');
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
$ans1 = max(array_map(
    fn ($x) => bindec(strtr($x, 'FBLR', '0101')),
    $input
));
// --------------------------------------------------------------------
// Part 2
$max = 1 << strlen($input[0] ?? '');
$seats = array_fill(0, $max, false);
foreach ($input as $line) {
    $seats[bindec(strtr($line, 'FBLR', '0101'))] = true;
}
$ans2 = 0;
while (($ans2 < $max) and !$seats[$ans2]) {
    ++$ans2;
}
while (($ans2 < $max) and $seats[$ans2]) {
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

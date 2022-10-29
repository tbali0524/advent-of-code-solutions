<?php

/*
https://adventofcode.com/2015/day/10
Part 1: Apply this process 40 times. What is the length of the result?
Part 2: Apply this process 50 times. What is the length of the new result?
topics: Conway's sequence, look-and-say sequence
*/

declare(strict_types=1);

// --------------------------------------------------------------------
const YEAR = 2015;
const DAY = '10';
const TITLE = 'Elves Look, Elves Say';
const SOLUTION1 = 360154;
const SOLUTION2 = 5103798;
$startTime = hrtime(true);
// ----------
$input = '1113122113';
// --------------------------------------------------------------------
// Part 1 + 2
$ans1 = 0;
const MAX1 = 40;
const MAX2 = 50;
$prev = $input;
for ($i = 0; $i < MAX2; ++$i) {
    if ($i == MAX1) {
        $ans1 = strlen($prev);
    }
    $next = '';
    $start = 0;
    while ($start < strlen($prev)) {
        $end = $start + 1;
        while (($end < strlen($prev)) and ($prev[$end] == $prev[$start])) {
            ++$end;
        }
        $next .= strval($end - $start) . $prev[$start];
        $start = $end;
    }
    $prev = $next;
}
$ans2 = strlen($next);
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

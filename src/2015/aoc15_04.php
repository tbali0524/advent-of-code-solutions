<?php

/*
https://adventofcode.com/2015/day/4
Part 1: You must find Santa the lowest positive number that produces such a hash.
Part 2: Now find one that starts with six zeroes.
*/

declare(strict_types=1);

// --------------------------------------------------------------------
const YEAR = 2015;
const DAY = '04';
const TITLE = 'The Ideal Stocking Stuffer';
const SOLUTION1 = 254575;
const SOLUTION2 = 1038736;
$startTime = hrtime(true);
// ----------
$input = 'bgvyzdsv';
// --------------------------------------------------------------------
// Part 1
$ans1 = 1;
while (substr(md5($input . strval($ans1)), 0, 5) !== '00000') {
    ++$ans1;
}
// --------------------------------------------------------------------
// Part 2
$ans2 = 1;
while (substr(md5($input . strval($ans2)), 0, 6) !== '000000') {
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

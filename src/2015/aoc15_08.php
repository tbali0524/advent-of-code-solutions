<?php

/*
https://adventofcode.com/2015/day/8
Part 1: Disregarding the whitespace in the file, what is the number of characters of code for string literals
minus the number of characters in memory for the values of the strings in total for the entire file?
Part 2: Your task is to find the total number of characters to represent the newly encoded strings
minus the number of characters of code in each original string literal.
*/

declare(strict_types=1);

// --------------------------------------------------------------------
const YEAR = 2015;
const DAY = '08';
const TITLE = 'Matchsticks';
const SOLUTION1 = 1371;
const SOLUTION2 = 2117;
$startTime = hrtime(true);
// ----------
$handle = fopen('input/' . YEAR . '/aoc15_08.txt', 'r');
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
    $ans1 += strlen($line);
    $i = 0;
    while ($i < strlen($line) - 2) {
        ++$i;
        --$ans1;
        if ($line[$i] == '\\') {
            if (($line[$i + 1] == '\\') or ($line[$i + 1] == '"')) {
                ++$i;
                continue;
            }
            if ($line[$i + 1] == 'x') {
                $i += 3;
                continue;
            }
        }
    }
}
// --------------------------------------------------------------------
// Part 2
$ans2 = 0;
foreach ($input as $line) {
    $ans2 += substr_count($line, '"') + substr_count($line, '\\') + 2;
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

<?php

/*
https://adventofcode.com/2015/day/5
Part 1: How many strings are nice?
Part 2: How many strings are nice under these new rules?
*/

declare(strict_types=1);

// --------------------------------------------------------------------
const YEAR = 2015;
const DAY = '05';
const TITLE = 'Doesn\'t He Have Intern-Elves For This?';
const SOLUTION1 = 238;
const SOLUTION2 = 69;
$startTime = hrtime(true);
// ----------
$handle = fopen('input/aoc15_05.txt', 'r');
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
    $count = 0;
    foreach (str_split('aeiou') as $needle) {
        $count += substr_count($line, $needle);
    }
    if ($count < 3) {
        continue;
    }
    $isNice = false;
    for ($i = 0; $i < 26; ++$i) {
        $c = chr(ord('a') + $i);
        if (str_contains($line, $c . $c)) {
            $isNice = true;
            break;
        }
    }
    if (!$isNice) {
        continue;
    }
    foreach (['ab', 'cd', 'pq', 'xy'] as $needle) {
        if (str_contains($line, $needle)) {
            $isNice = false;
            break;
        }
    }
    if ($isNice) {
        ++$ans1;
    }
}
// --------------------------------------------------------------------
// Part 2
$ans2 = 0;
foreach ($input as $line) {
    $firstPos = [];
    $isNice = false;
    for ($i = 1; $i < strlen($line); ++$i) {
        $pair = $line[$i - 1] . $line[$i];
        if (isset($firstPos[$pair])) {
            if ($i - $firstPos[$pair] >= 2) {
                $isNice = true;
                break;
            }
            continue;
        }
        $firstPos[$pair] = $i;
    }
    if (!$isNice) {
        continue;
    }
    $isNice = false;
    for ($i = 2; $i < strlen($line); ++$i) {
        if ($line[$i] == $line[$i - 2]) {
            $isNice = true;
            break;
        }
    }
    if ($isNice) {
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

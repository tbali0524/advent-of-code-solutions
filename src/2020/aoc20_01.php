<?php

/*
https://adventofcode.com/2020/day/1
Part 1: Find the two entries that sum to 2020 and then multiply those two numbers together.
Part 2: What is the product of the three entries that sum to 2020?
*/

// p hpcs:disable PSR1.Files.SideEffects, PSR1.Classes.ClassDeclaration
// @ phpstan-ignore-next-line

declare(strict_types=1);

// --------------------------------------------------------------------
const YEAR = 2020;
const DAY = '01';
const TITLE = 'Report Repair';
const SOLUTION1 = 988771;
const SOLUTION2 = 171933104;
$startTime = hrtime(true);
// ----------
$handle = fopen('input/' . YEAR . '/aoc20_01.txt', 'r');
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
    $input[] = intval($line);
}
fclose($handle);
// --------------------------------------------------------------------
// Part 1
$ans1 = 0;
$visited = [];
foreach ($input as $i) {
    if (isset($visited[2020 - $i])) {
        $ans1 = $i * (2020 - $i);
        break;
    }
    $visited[$i] = true;
}
// --------------------------------------------------------------------
// Part 2
$ans2 = 0;
$visited = [];
foreach ($input as $idx => $i) {
    foreach ($input as $idx2 => $j) {
        if ($idx != $idx2) {
            $visited[$i + $j] = $i * $j;
        }
    }
}
foreach ($input as $i) {
    if (isset($visited[2020 - $i])) {
        $ans2 = $i * $visited[2020 - $i];
        break;
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

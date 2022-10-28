<?php

/*
https://adventofcode.com/2016/day/1
Part 1: How many blocks away is Easter Bunny HQ?
Part 2: How many blocks away is the first location you visit twice?
*/

declare(strict_types=1);

// --------------------------------------------------------------------
const YEAR = 2016;
const DAY = '01';
const TITLE = 'No Time for a Taxicab';
const SOLUTION1 = 262;
const SOLUTION2 = 131;
$startTime = hrtime(true);
// ----------
$handle = fopen('input/' . YEAR . '/aoc16_01.txt', 'r');
if ($handle === false) {
    throw new \Exception('Cannot load input file');
}
$input = '';
while (true) {
    $line = fgets($handle);
    if ($line === false) {
        break;
    }
    if (trim($line) == '') {
        continue;
    }
    $input = trim($line);
}
fclose($handle);
// --------------------------------------------------------------------
// Part 1
$ans1 = 0;
const DELTAS = [[0, 1], [1, 0], [0, -1], [-1, 0]];
const TURNS = ['R' => 1, 'L' => -1];
$x = 0;
$y = 0;
$direction = 0; // N
foreach (explode(', ', $input) as $instruction) {
    $turn = TURNS[$instruction[0]] ?? 0;
    $move = intval(substr($instruction, 1));
    $direction = ($direction + $turn + 4) % 4;
    [$dx, $dy] = DELTAS[$direction];
    $x += $dx * $move;
    $y += $dy * $move;
}
$ans1 = abs($x) + abs($y);
// --------------------------------------------------------------------
// Part 2
$ans2 = 0;
$x = 0;
$y = 0;
$direction = 0; // N
$memo = [];
$memo[$y][$x] = true;
foreach (explode(', ', $input) as $instruction) {
    $turn = TURNS[$instruction[0]] ?? 0;
    $move = intval(substr($instruction, 1));
    $direction = ($direction + $turn + 4) % 4;
    [$dx, $dy] = DELTAS[$direction];
    for ($i = 0; $i < $move; ++$i) {
        $x += $dx;
        $y += $dy;
        if (isset($memo[$y][$x])) {
            $ans2 = abs($x) + abs($y);
            break 2;
        }
        $memo[$y][$x] = true;
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

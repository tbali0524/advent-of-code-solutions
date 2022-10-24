<?php

/*
https://adventofcode.com/2020/day/2
Part 1: Starting at the top-left corner of your map and following a slope of right 3 and down 1,
how many trees would you encounter?
Part 2: What do you get if you multiply together the number of trees encountered on each of the listed slopes?
*/

declare(strict_types=1);

// --------------------------------------------------------------------
const YEAR = 2020;
const DAY = '03';
const TITLE = 'Toboggan Trajectory';
const SOLUTION1 = 211;
const SOLUTION2 = 3584591857;
$startTime = hrtime(true);
// ----------
$handle = fopen('input/aoc20_03.txt', 'r');
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
$maxY = count($input);
$maxX = strlen($input[0]);
$y = 0;
$x = 0;
while ($y < $maxY) {
    if ($input[$y][$x] == '#') {
        ++$ans1;
    }
    ++$y;
    $x = ($x + 3) % $maxX;
}
// --------------------------------------------------------------------
// Part 2
$ans2 = 1;
$maxY = count($input);
$maxX = strlen($input[0]);
const SLOPES = [[1, 1], [3, 1], [5, 1], [7, 1], [1, 2]];
foreach (SLOPES as $dxy) {
    [$dx, $dy] = $dxy;
    $y = 0;
    $x = 0;
    $count = 0;
    while ($y < $maxY) {
        if ($input[$y][$x] == '#') {
            ++$count;
        }
        $y += $dy;
        $x = ($x + $dx) % $maxX;
    }
    $ans2 *= $count;
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

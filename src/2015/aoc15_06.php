<?php

/*
https://adventofcode.com/2015/day/6
Part 1: How many total square feet of wrapping paper should they order?
Part 2: What is the total brightness of all lights combined after following Santa's instructions?
*/

declare(strict_types=1);

// --------------------------------------------------------------------
const YEAR = 2015;
const DAY = '06';
const TITLE = 'Probably a Fire Hazard';
const SOLUTION1 = 377891;
const SOLUTION2 = 14110788;
$startTime = hrtime(true);
// ----------
$handle = fopen('input/' . YEAR . '/aoc15_06.txt', 'r');
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
    $instructionWords = str_starts_with($line, 'turn') ? 2 : 1;
    $a = explode(' ', trim($line));
    if (count($a) != 3 + $instructionWords) {
        throw new \Exception('Invalid input');
    }
    $b = explode(',', $a[$instructionWords]);
    $c = explode(',', $a[2 + $instructionWords]);
    if ((count($b) != 2) or (count($c) != 2) or ($a[1 + $instructionWords] != 'through')) {
        throw new \Exception('Invalid input');
    }
    $input[] = [
        'instruction' => $instructionWords == 1 ? $a[0] : $a[0] . ' ' . $a[1],
        'x0' => intval($b[0]),
        'y0' => intval($b[1]),
        'x1' => intval($c[0]),
        'y1' => intval($c[1]),
    ];
}
fclose($handle);
// --------------------------------------------------------------------
// Part 1
$ans1 = 0;
const MAX = 1000;
$grid = array_fill(0, MAX, array_fill(0, MAX, false));
foreach ($input as $line) {
    for ($y = $line['y0']; $y <= $line['y1']; ++$y) {
        for ($x = $line['x0']; $x <= $line['x1']; ++$x) {
            if ($line['instruction'] == 'toggle') {
                $grid[$y][$x] = !$grid[$y][$x];
            } elseif ($line['instruction'] == 'turn on') {
                $grid[$y][$x] = true;
            } elseif ($line['instruction'] == 'turn off') {
                $grid[$y][$x] = false;
            }
        }
    }
}
$ans1 = array_sum(array_map(fn ($row) => count(array_filter($row, fn ($x) => $x)), $grid));
// --------------------------------------------------------------------
// Part 2
$ans2 = 0;
$grid = array_fill(0, MAX, array_fill(0, MAX, 0));
foreach ($input as $line) {
    for ($y = $line['y0']; $y <= $line['y1']; ++$y) {
        for ($x = $line['x0']; $x <= $line['x1']; ++$x) {
            if ($line['instruction'] == 'toggle') {
                $grid[$y][$x] += 2;
            } elseif ($line['instruction'] == 'turn on') {
                ++$grid[$y][$x];
            } elseif ($line['instruction'] == 'turn off') {
                $grid[$y][$x] = max(0, $grid[$y][$x] - 1);
            }
        }
    }
}
$ans2 = array_sum(array_map(fn ($row) => array_sum($row), $grid));
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

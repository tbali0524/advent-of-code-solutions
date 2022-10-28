<?php

/*
https://adventofcode.com/2015/day/18
Part 1: How many lights are on after 100 steps?
Part 2: With the four corners always in the on state, how many lights are on after 100 steps?
topics: Conway's Game of Life
*/

// phpcs:disable PSR1.Files.SideEffects

declare(strict_types=1);

namespace TBali\Aoc15_18;

// --------------------------------------------------------------------
const YEAR = 2015;
const DAY = '18';
const TITLE = 'Like a GIF For Your Yard';
const SOLUTION1 = 814;
const SOLUTION2 = 924;
$startTime = hrtime(true);
// ----------
$handle = fopen('input/' . YEAR . '/aoc15_18.txt', 'r');
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
// Part 1 + 2
const MAX = 100;
const STEPS = 100;
const CORNERS = [[0, 0], [0, MAX - 1], [MAX - 1, 0], [MAX - 1, MAX - 1]];
$ans1 = simulate($input, false);
$ans2 = simulate($input, true);
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

// --------------------------------------------------------------------
/** @param string[] $input */
function simulate(array $input, bool $stuckCorners = false): int
{
    $prev = $input;
    if ($stuckCorners) {
        foreach (CORNERS as $xy) {
            [$x, $y] = $xy;
            $prev[$y][$x] = '#';
        }
    }
    for ($step = 0; $step < STEPS; ++$step) {
        $next = $prev;
        for ($y = 0; $y < MAX; ++$y) {
            for ($x = 0; $x < MAX; ++$x) {
                if ($stuckCorners and in_array([$x, $y], CORNERS, true)) {
                    continue;
                }
                $count = 0;
                for ($dy = -1; $dy <= 1; ++$dy) {
                    for ($dx = -1; $dx <= 1; ++$dx) {
                        if (($dx == 0) and ($dy == 0)) {
                            continue;
                        }
                        $x1 = $x + $dx;
                        $y1 = $y + $dy;
                        if (($x1 < 0) or ($x1 >= MAX) or ($y1 < 0) or ($y1 >= MAX)) {
                            continue;
                        }
                        if ($prev[$y1][$x1] == '#') {
                            ++$count;
                        }
                    }
                }
                if ($prev[$y][$x] == '#') {
                    $next[$y][$x] = (($count == 2 || $count == 3) ? '#' : '.');
                } elseif ($prev[$y][$x] == '.') {
                    $next[$y][$x] = ($count == 3 ? '#' : '.');
                }
            }
        }
        $prev = $next;
    }
    return array_sum(array_map(fn ($row) => substr_count($row, '#'), $next));
}

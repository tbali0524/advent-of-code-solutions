<?php

/*
https://adventofcode.com/2020/day/10
Part 1: What is the number of 1-jolt differences multiplied by the number of 3-jolt differences?
Part 2: What is the total number of distinct ways you can arrange the adapters to connect
    the charging outlet to your device?
*/

// phpcs:disable PSR1.Files.SideEffects

declare(strict_types=1);

namespace TBali\Aoc20_10;

// --------------------------------------------------------------------
const YEAR = 2020;
const DAY = '10';
const TITLE = 'Adapter Array';
const SOLUTION1 = 2112;
const SOLUTION2 = 3022415986688;
$startTime = hrtime(true);
// ----------
$handle = fopen('input/' . YEAR . '/aoc20_10.txt', 'r');
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
$a = $input;
$a[] = max($input) + 3;
$a[] = 0;
sort($a);
for ($i = 1; $i < count($a); ++$i) {
    $counts[$a[$i] - $a[$i - 1]] = ($counts[$a[$i] - $a[$i - 1]] ?? 0) + 1;
}
$ans1 = $counts[1] * $counts[3];
// --------------------------------------------------------------------
// Part 2
$ans2 = solve($a);
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
/** @param int[] $a */
function solve(array $a, int $idx = -1)
{
    static $memo = [];

    if ($idx < 0) {
        $idx = count($a) - 1;
    }
    if (isset($memo[$idx])) {
        return $memo[$idx];
    }
    if ($idx == 0) {
        $ans = 1;
    } else {
        $ans = 0;
        for ($i = 1; $i <= 3; ++$i) {
            if ($idx - $i < 0) {
                break;
            }
            if ($a[$idx] - $a[$idx - $i] > 3) {
                break;
            }
            $ans += solve($a, $idx - $i);
        }
    }
    $memo[$idx] = $ans;
    return $ans;
}

<?php

/*
https://adventofcode.com/2015/day/16
Part 1: What is the number of the Sue that got you the gift?
Part 2: What is the number of the real Aunt Sue?
*/

// phpcs:disable PSR1.Files.SideEffects

declare(strict_types=1);

namespace TBali\Aoc15_16;

// --------------------------------------------------------------------
const YEAR = 2015;
const DAY = '16';
const TITLE = 'Aunt Sue';
const SOLUTION1 = 373;
const SOLUTION2 = 260;
$startTime = hrtime(true);
// ----------
$handle = fopen('input/' . YEAR . '/aoc15_16.txt', 'r');
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
$aunts = parseInput($input);
const AUNT_SPEC = [
    'children' => 3,
    'cats' => 7,
    'samoyeds' => 2,
    'pomeranians' => 3,
    'akitas' => 0,
    'vizslas' => 0,
    'goldfish' => 5,
    'trees' => 3,
    'cars' => 2,
    'perfumes' => 1,
];
foreach ($aunts as $id => $aunt) {
    $isOk = true;
    foreach ($aunt as $propName => $propValue) {
        if ((AUNT_SPEC[$propName] ?? -1) != $propValue) {
            $isOk = false;
            break;
        }
    }
    if ($isOk) {
        $ans1 = $id;
        break;
    }
}
// --------------------------------------------------------------------
// Part 2
$ans2 = 0;
const EXPECTED_COMPARE_RESULT = [
    'children' => 0,
    'cats' => 1,
    'samoyeds' => 0,
    'pomeranians' => -1,
    'akitas' => 0,
    'vizslas' => 0,
    'goldfish' => -1,
    'trees' => 1,
    'cars' => 0,
    'perfumes' => 0,
];
foreach ($aunts as $id => $aunt) {
    $isOk = true;
    foreach ($aunt as $propName => $propValue) {
        if (!isset(AUNT_SPEC[$propName])) {
            continue;
        }
        $comp =  $propValue <=> AUNT_SPEC[$propName];
        if ($comp != EXPECTED_COMPARE_RESULT[$propName]) {
            $isOk = false;
            break;
        }
    }
    if ($isOk) {
        $ans2 = $id;
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

// --------------------------------------------------------------------
/**
 * @param string[] $input
 *
 * @return array<int, array<string, int>>
 */
function parseInput(array $input): array
{
    $aunts = [];
    foreach ($input as $line) {
        $a = explode(' ', $line);
        if (count($a) != 8) {
            throw new \Exception('Invalid input');
        }
        $aunt = [];
        $id = intval(substr($a[1], 0, -1));
        for ($i = 0; $i < 3; ++$i) {
            $propName = substr($a[2 + 2 * $i], 0, -1);
            if ($i < 2) {
                $propValue = intval(substr($a[3 + 2 * $i], 0, -1));
            } else {
                $propValue = intval($a[7]);
            }
            $aunt[$propName] = $propValue;
        }
        $aunts[$id] = $aunt;
    }
    return $aunts;
}

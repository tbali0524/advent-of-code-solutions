<?php

/*
https://adventofcode.com/2015/day/12
Part 1: What is the sum of all numbers in the document?
Part 2: Uh oh - the Accounting-Elves have realized that they double-counted everything red.
*/

// phpcs:disable PSR1.Files.SideEffects

declare(strict_types=1);

// --------------------------------------------------------------------
const YEAR = 2015;
const DAY = '12';
const TITLE = 'JSAbacusFramework.io';
const SOLUTION1 = 111754;
const SOLUTION2 = 65402;
$startTime = hrtime(true);
// ----------
$handle = fopen('input/' . YEAR . '/aoc15_12.txt', 'r');
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
    $input .= trim($line);
}
fclose($handle);
// --------------------------------------------------------------------
// Part 1
$a = json_decode($input, true); // true: JSON objects will be returned as associative arrays
$count = 0;
array_walk_recursive($a, function ($x) use (&$count) {
    if (is_numeric($x)) {
        $count += intval($x);
    }
}, $count);
$ans1 = $count;
// --------------------------------------------------------------------
// Part 2
$a = json_decode($input, false); // JSON objects will be returned as objects.
$ans2 = sumNonRed($a);
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
function sumNonRed(mixed $a): int
{
    if (is_numeric($a)) {
        return intval($a);
    }
    if (is_object($a)) {
        $isOk = true;
        foreach ($a as $item) {
            if ($item == 'red') {
                $isOk = false;
                break;
            }
        }
        if (!$isOk) {
            return 0;
        }
    }
    if (!is_array($a) and !is_object($a)) {
        return 0;
    }
    $sum = 0;
    foreach ($a as $item) {
        $sum += sumNonRed($item);
    }
    return $sum;
}

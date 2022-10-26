<?php

/*
https://adventofcode.com/2015/day/11
Part 1: Given Santa's current password (your puzzle input), what should his next password be?
Part 2: Santa's password expired again. What's the next one?
*/

// phpcs:disable PSR1.Files.SideEffects

declare(strict_types=1);

// --------------------------------------------------------------------
const YEAR = 2015;
const DAY = '11';
const TITLE = 'Corporate Policy';
const SOLUTION1 = 'vzbxxyzz';
const SOLUTION2 = 'vzcaabcc';
$startTime = hrtime(true);
// ----------
$input = 'vzbxkghb';
// --------------------------------------------------------------------
// Part 1
$ans1 = getNextPassword($input);
// --------------------------------------------------------------------
// Part 2
$ans2 = getNextPassword($ans1);
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
function getNextPassword(string $pw): string
{
    while (true) {
        $i = strlen($pw) - 1;
        while (($i >= 0) and ($pw[$i] == 'z')) {
            $pw[$i] = 'a';
            $i--;
        }
        if ($i < 0) {
            throw new \Exception('Password overflow');
        }
        $pw[$i] = chr(ord($pw[$i]) + 1);
        $isOk = false;
        for ($i = 2; $i < strlen($pw); ++$i) {
            if ((ord($pw[$i]) - ord($pw[$i - 1]) == 1) and (ord($pw[$i - 1]) - ord($pw[$i - 2]) == 1)) {
                $isOk = true;
                break;
            }
        }
        if (!$isOk) {
            continue;
        }
        $count = 0;
        foreach (str_split('iol') as $needle) {
            $count += substr_count($pw, $needle);
        }
        if ($count > 0) {
            continue;
        }
        $firstPos = [];
        $count = 0;
        for ($i = 1; $i < strlen($pw); ++$i) {
            if ($pw[$i] != $pw[$i - 1]) {
                continue;
            }
            if (isset($firstPos[$pw[$i]])) {
                if ($i - $firstPos[$pw[$i]] == 1) {
                    continue;
                }
            } else {
                $firstPos[$pw[$i]] = $i;
            }
            ++$count;
        }
        if ($count >= 2) {
            break;
        }
    }
    return $pw;
}

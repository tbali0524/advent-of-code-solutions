<?php

/*
https://adventofcode.com/2015/day/15
Part 1: What is the total score of the highest-scoring cookie you can make?
Part 2: what is the total score of the highest-scoring cookie you can make with a calorie total of 500?
*/

// phpcs:disable PSR1.Files.SideEffects

declare(strict_types=1);

namespace TBali\Aoc15_14;

// --------------------------------------------------------------------
const YEAR = 2015;
const DAY = '15';
const TITLE = 'Science for Hungry People';
const SOLUTION1 = 21367368;
const SOLUTION2 = 1766400;
$startTime = hrtime(true);
// ----------
$handle = fopen('input/' . YEAR . '/aoc15_15.txt', 'r');
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
$ans1 = 0;
$ans2 = 0;
$ingredients = parseInput($input);
const TOTAL_QUANTITY = 101; // must be total + 1!!!
$powers = array_map(fn ($x) => TOTAL_QUANTITY ** $x, range(0, count($ingredients)));
for ($code = 0; $code < $powers[count($ingredients) - 1]; ++$code) {
    $quantities = [];
    $remaining_quantity = TOTAL_QUANTITY - 1;
    for ($idx = 0; $idx < count($ingredients) - 1; ++$idx) {
        $qty = intdiv($code, $powers[$idx]) % TOTAL_QUANTITY;
        $quantities[] = $qty;
        $remaining_quantity -= $qty;
        if ($remaining_quantity < 0) {
            break;
        }
    }
    if ($remaining_quantity < 0) {
        continue;
    }
    $quantities[] = $remaining_quantity;
    $product = 1;
    foreach (['capacity', 'durability', 'flavor', 'texture'] as $property) {
        $sum = 0;
        foreach ($ingredients as $idx => $ingredient) {
            $sum += ($ingredient[$property] ?? 0) * $quantities[$idx];
        }
        $sum = max(0, $sum);
        $product *= $sum;
    }
    $sum_calory = 0;
    foreach ($ingredients as $idx => $ingredient) {
        $sum_calory += ($ingredient['calories'] ?? 0) * $quantities[$idx];
    }
    $ans1 = max($ans1, $product);
    if ($sum_calory == 500) {
        $ans2 = max($ans2, $product);
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
    $ingredients = [];
    foreach ($input as $line) {
        $a = explode(' ', $line);
        if (count($a) != 11) {
            throw new \Exception('Invalid input');
        }
        $ingredient = [];
        for ($i = 0; $i < 5; ++$i) {
            $propName = $a[1 + 2 * $i];
            if ($i < 4) {
                $propValue = intval(substr($a[2 + 2 * $i], 0, -1));
            } else {
                $propValue = intval($a[10]);
            }
            $ingredient[$propName] = $propValue;
        }
        // $ingredient['name'] = substr($a[0], 0, -1);
        $ingredients[] = $ingredient;
    }
    return $ingredients;
}

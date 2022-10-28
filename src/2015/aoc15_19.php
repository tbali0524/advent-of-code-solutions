<?php

/*
https://adventofcode.com/2015/day/19
Part 1: How many distinct molecules can be created after all the different ways you can do one replacement
    on the medicine molecule?
Part 2: What is the fewest number of steps to go from e to the medicine molecule?
topics: DFS
*/

declare(strict_types=1);

// --------------------------------------------------------------------
const YEAR = 2015;
const DAY = '19';
const TITLE = 'Medicine for Rudolph';
const SOLUTION1 = 535;
const SOLUTION2 = 212;
$startTime = hrtime(true);
// ----------
$handle = fopen('input/' . YEAR . '/aoc15_19.txt', 'r');
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
// input processing common to part 1 and 2
$replacements = [];
$reverse = [];
$molecule = $input[count($input) - 1];
for ($i = 0; $i < count($input) - 1; ++$i) {
    $a = explode(' => ', $input[$i]);
    if (count($a) != 2) {
        throw new \Exception('Invalid input');
    }
    if (isset($replacements[$a[0]])) {
        $replacements[$a[0]][] = $a[1];
    } else {
        $replacements[$a[0]] = [$a[1]];
    }
    $reverse[$a[1]] = $a[0];
}
// --------------------------------------------------------------------
// Part 1
$resultSet = [];
for ($i = 0; $i < strlen($molecule); ++$i) {
    $elem = $molecule[$i];
    if (!isset($replacements[$elem])) {
        continue;
    }
    foreach ($replacements[$elem] as $newElem) {
        $newMolecule = substr($molecule, 0, $i) . $newElem . substr($molecule, $i + 1);
        $resultSet[$newMolecule] = true;
    }
}
for ($i = 0; $i < strlen($molecule) - 1; ++$i) {
    $elem = substr($molecule, $i, 2);
    if (!isset($replacements[$elem])) {
        continue;
    }
    foreach ($replacements[$elem] as $newElem) {
        $newMolecule = substr($molecule, 0, $i) . $newElem . substr($molecule, $i + 2);
        $resultSet[$newMolecule] = true;
    }
}
$ans1 = count($resultSet);
// --------------------------------------------------------------------
// Part 2
$ans2 = 0;
// Note: not a correct solution but works for this specific input
$newMolecule = $molecule;
while ($newMolecule != 'e') {
    foreach ($reverse as $to => $from) {
        if (str_contains($newMolecule, $to)) {
            $count = 0;
            $newMolecule = str_replace($to, $from, $newMolecule, $count);
            $ans2 += $count;
        }
    }
}
// Note: a correct solution, but timeouts
// $visited = ['e' => true];
// $q = [['e', 0]];
// $readIdx = 0;
// while (true) {
//     if ($readIdx >= count($q)) {
//         throw new \Exception('No solution found');
//     }
//     [$currMolecule, $currStep] = $q[$readIdx];
//     ++$readIdx;
//     if (strlen($currMolecule) > strlen($molecule)) {
//         continue;
//     }
//     if ($currMolecule == $molecule) {
//         $ans2 = $currStep;
//         break;
//     }
//     for ($i = 0; $i < strlen($currMolecule); ++$i) {
//         $elem = $currMolecule[$i];
//         if (!isset($replacements[$elem])) {
//             continue;
//         }
//         foreach ($replacements[$elem] as $newElem) {
//             $newMolecule = substr($currMolecule, 0, $i) . $newElem . substr($currMolecule, $i + 1);
//             if (isset($visited[$newMolecule])) {
//                 continue;
//             }
//             $q[] = [$newMolecule, $currStep + 1];
//             $visited[$newMolecule] = true;
//         }
//     }
//     for ($i = 0; $i < strlen($currMolecule) - 1; ++$i) {
//         $elem = substr($currMolecule, $i, 2);
//         if (!isset($replacements[$elem])) {
//             continue;
//         }
//         foreach ($replacements[$elem] as $newElem) {
//             $newMolecule = substr($currMolecule, 0, $i) . $newElem . substr($currMolecule, $i + 2);
//             if (isset($visited[$newMolecule])) {
//                 continue;
//             }
//             $q[] = [$newMolecule, $currStep + 1];
//             $visited[$newMolecule] = true;
//         }
//     }
// }
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

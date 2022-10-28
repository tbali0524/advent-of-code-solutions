<?php

/*
https://adventofcode.com/2015/day/23
Part 1: What is the value in register b when the program in your puzzle input is finished executing?
Part 2: What is the value in register b after the program is finished executing if register a starts as 1 instead?
*/

// phpcs:disable PSR1.Files.SideEffects

declare(strict_types=1);

namespace TBali\Aoc15_23;

// --------------------------------------------------------------------
const YEAR = 2015;
const DAY = '23';
const TITLE = 'Opening the Turing Lock';
const SOLUTION1 = 170;
const SOLUTION2 = 247;
$startTime = hrtime(true);
// ----------
$handle = fopen('input/' . YEAR . '/aoc15_23.txt', 'r');
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
$ans1 = execute($input, ['a' => 0, 'b' => 0])['b'] ?? 0;
$ans2 = execute($input, ['a' => 1, 'b' => 0])['b'] ?? 0;
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
 * @param string[]           $input
 * @param array<string, int> $registers
 *
 * @return array<string, int> The registers at end of execution
 */
function execute(array $input, array $registers): array
{
    $pc = -1;
    while (true) {
        ++$pc;
        if (($pc < 0) or ($pc >= count($input))) {
            return $registers;
        }
        $instruction = substr($input[$pc], 0, 3);
        switch ($instruction) {
            case 'hlf':
                $r = $input[$pc][4];
                $registers[$r] = intdiv($registers[$r] ?? 0, 2);
                break;
            case 'tpl':
                $r = $input[$pc][4];
                $registers[$r] = 3 * ($registers[$r] ?? 0);
                break;
            case 'inc':
                $r = $input[$pc][4];
                $registers[$r] = ($registers[$r] ?? 0) + 1;
                break;
            case 'jmp':
                $offset = intval(substr($input[$pc], 4));
                $pc += $offset - 1;
                break;
            case 'jie':
                $r = $input[$pc][4];
                $offset = intval(substr($input[$pc], 6));
                if (($registers[$r] ?? -1) % 2 == 0) {
                    $pc += $offset - 1;
                }
                break;
            case 'jio':
                $r = $input[$pc][4];
                $offset = intval(substr($input[$pc], 6));
                if (($registers[$r] ?? 0) == 1) {
                    $pc += $offset - 1;
                }
                break;
            default:
                throw new \Exception('Invalid instruction');
        }
    }
}

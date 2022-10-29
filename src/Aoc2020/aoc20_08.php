<?php

/*
https://adventofcode.com/2020/day/8
Part 1: Immediately before any instruction is executed a second time, what value is in the accumulator?
Part 2: What is the value of the accumulator after the program terminates?
*/

// phpcs:disable PSR1.Files.SideEffects

declare(strict_types=1);

namespace TBali\Aoc20_08;

// --------------------------------------------------------------------
const YEAR = 2020;
const DAY = '08';
const TITLE = 'Handheld Halting';
const SOLUTION1 = 1749;
const SOLUTION2 = 515;
$startTime = hrtime(true);
// ----------
$handle = fopen('input/' . YEAR . '/aoc20_08.txt', 'r');
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
[$wasInfLoop, $ans1] = execute($input);
if (!$wasInfLoop) {
    throw new \Exception('Part 1 supposed to contain an inifinite loop');
}
// --------------------------------------------------------------------
// Part 2
$ans2 = 0;
for ($i = 0; $i < count($input); ++$i) {
    $instruction = substr($input[$i], 0, 3);
    if (!in_array($instruction, ['jmp', 'nop'])) {
        continue;
    }
    $modInstruction = ['jmp' => 'nop', 'nop' => 'jmp'][$instruction] ?? 'err';
    $modInput = $input;
    $modInput[$i] = $modInstruction . substr($input[$i], 3);
    [$wasInfLoop, $ans2] = execute($modInput);
    if (!$wasInfLoop) {
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
 * @return array{bool, int} first item: was there an infinite loop? second item: The accumulator at exit
 */
function execute(array $input): array
{
    $memo = [];
    $a = 0;
    $pc = -1;
    while (true) {
        ++$pc;
        if (($pc < 0) or ($pc >= count($input))) {
            return [false, $a];
        }
        if (isset($memo[$pc])) {
            return [true, $a];
        }
        $memo[$pc] = true;
        $instruction = substr($input[$pc], 0, 3);
        switch ($instruction) {
            case 'acc':
                $offset = intval(substr($input[$pc], 4));
                $a += $offset;
                break;
            case 'jmp':
                $offset = intval(substr($input[$pc], 4));
                $pc += $offset - 1;
                break;
            case 'nop':
                break;
            default:
                throw new \Exception('Invalid instruction');
        }
    }
}

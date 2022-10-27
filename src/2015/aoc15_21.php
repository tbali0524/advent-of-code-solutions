<?php

/*
https://adventofcode.com/2015/day/21
Part 1: What is the least amount of gold you can spend and still win the fight?
Part 2: What is the most amount of gold you can spend and still lose the fight?
*/

// phpcs:disable PSR1.Files.SideEffects, PSR1.Classes.ClassDeclaration

declare(strict_types=1);

namespace TBali\Aoc15_21;

// --------------------------------------------------------------------
const YEAR = 2015;
const DAY = '21';
const TITLE = 'RPG Simulator 20XX';
const SOLUTION1 = 111;
const SOLUTION2 = 188;
$startTime = hrtime(true);
// ----------
$handle = fopen('input/' . YEAR . '/aoc15_21.txt', 'r');
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
    $a = explode(': ', trim($line));
    if (count($a) != 2) {
        throw new \Exception('Invalid input');
    }
    $input[] = intval($a[1]);
}
fclose($handle);
// --------------------------------------------------------------------
// Part 1
$enemy = new Character(...$input);
const PLAYER_HP = 100;
// cost, damage, armor
const WEAPONS = [
    [8, 4, 0],
    [10, 5, 0],
    [25, 6, 0],
    [40, 7, 0],
    [74, 8, 0],
];
const ARMORS = [
    [0, 0, 0],  // armor is optional
    [13, 0, 1],
    [31, 0, 2],
    [53, 0, 3],
    [75, 0, 4],
    [102, 0, 5],
];
const RINGS = [
    [0, 0, 0],  // ring is optional
    [25, 1, 0],
    [50, 2, 0],
    [100, 3, 0],
    [20, 0, 1],
    [40, 0, 2],
    [80, 0, 3],
];
$ans1 = PHP_INT_MAX;
$ans2 = 0;
foreach (WEAPONS as $weapon) {
    foreach (ARMORS as $armor) {
        foreach (RINGS as $id1 => $ring1) {
            foreach (RINGS as $id2 => $ring2) {
                if (($id1 != 0) and ($id1 == $id2)) {
                    continue;
                }
                $cost = $weapon[0] + $armor[0] + $ring1[0] + $ring2[0];
                $damage = $weapon[1] + $armor[1] + $ring1[1] + $ring2[1];
                $sum_armor = $weapon[2] + $armor[2] + $ring1[2] + $ring2[2];
                $player = new Character(PLAYER_HP, $damage, $sum_armor);
                if ($player->canWin($enemy)) {
                    $ans1 = min($ans1, $cost);
                } else {
                    $ans2 = max($ans2, $cost);
                }
            }
        }
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
class Character
{
    public function __construct(
        public readonly int $hp = 0,
        public readonly int $damage = 0,
        public readonly int $armor = 0,
    ) {
    }

    public function canWin(Character $enemy): bool
    {
        $turnsToWin = intval(ceil($enemy->hp / max(1, $this->damage - $enemy->armor)));
        $turnsToLoose = intval(ceil($this->hp / max(1, $enemy->damage - $this->armor)));
        return $turnsToWin <= $turnsToLoose;
    }
}

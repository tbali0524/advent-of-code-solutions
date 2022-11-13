<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2015;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2015 Day 21: RPG Simulator 20XX.
 *
 * Part 1: What is the least amount of gold you can spend and still win the fight?
 * Part 2: What is the most amount of gold you can spend and still lose the fight?
 *
 * Topics: game simulation
 *
 * @see https://adventofcode.com/2015/day/21
 */
final class Aoc2015Day21 extends SolutionBase
{
    public const YEAR = 2015;
    public const DAY = 21;
    public const TITLE = 'RPG Simulator 20XX';
    public const SOLUTIONS = [111, 188];

    private const PLAYER_HP = 100;
    // cost, damage, armor
    private const WEAPONS = [
        [8, 4, 0],
        [10, 5, 0],
        [25, 6, 0],
        [40, 7, 0],
        [74, 8, 0],
    ];
    private const ARMORS = [
        [0, 0, 0],  // armor is optional
        [13, 0, 1],
        [31, 0, 2],
        [53, 0, 3],
        [75, 0, 4],
        [102, 0, 5],
    ];
    private const RINGS = [
        [0, 0, 0],  // ring is optional
        [25, 1, 0],
        [50, 2, 0],
        [100, 3, 0],
        [20, 0, 1],
        [40, 0, 2],
        [80, 0, 3],
    ];

    /**
     * Solve both parts of the puzzle for a given input, without IO.
     *
     * @param array<int, string> $input The lines of the input, without LF
     *
     * @return array<int, string> The answers for Part 1 and Part 2 (as strings)
     *
     * @phpstan-return array{string, string}
     */
    public function solve(array $input): array
    {
        // ---------- Part 1 + 2
        $processedInput = [];
        foreach ($input as $line) {
            $a = explode(': ', trim($line));
            if (count($a) != 2) {
                throw new \Exception('Invalid input');
            }
            $processedInput[] = intval($a[1]);
        }
        $enemy = new Character(...$processedInput);
        $ans1 = PHP_INT_MAX;
        $ans2 = 0;
        foreach (self::WEAPONS as $weapon) {
            foreach (self::ARMORS as $armor) {
                foreach (self::RINGS as $id1 => $ring1) {
                    foreach (self::RINGS as $id2 => $ring2) {
                        if (($id1 != 0) and ($id1 == $id2)) {
                            continue;
                        }
                        $cost = $weapon[0] + $armor[0] + $ring1[0] + $ring2[0];
                        $damage = $weapon[1] + $armor[1] + $ring1[1] + $ring2[1];
                        $sum_armor = $weapon[2] + $armor[2] + $ring1[2] + $ring2[2];
                        $player = new Character(self::PLAYER_HP, $damage, $sum_armor);
                        if ($player->canWin($enemy)) {
                            $ans1 = min($ans1, $cost);
                        } else {
                            $ans2 = max($ans2, $cost);
                        }
                    }
                }
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}

// --------------------------------------------------------------------
final class Character
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

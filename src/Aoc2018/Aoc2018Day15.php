<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2018;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2018 Day 15: Beverage Bandits.
 *
 * Part 1: What is the outcome of the combat described in your puzzle input?
 * Part 2: After increasing the Elves' attack power until it is just barely enough for them to win without any
 *         Elves dying, what is the outcome of the combat described in your puzzle input?
 *
 * Topics: game simulation
 *
 * @see https://adventofcode.com/2018/day/15
 */
final class Aoc2018Day15 extends SolutionBase
{
    public const YEAR = 2018;
    public const DAY = 15;
    public const TITLE = 'Beverage Bandits';
    public const SOLUTIONS = [207542, 64688];
    public const EXAMPLE_SOLUTIONS = [
        [27730, 4988],
        [36334, 0],
        [39514, 31284],
        [27755, 3478],
        [28944, 6474],
        [18740, 1140],
    ];

    private const DEBUG = false;
    private const EMPTY = '.';

    private int $maxX = 0;
    private int $maxY = 0;
    /** @var array<int, string> */
    private array $startGrid = [];
    /** @var array<int, Creature> */
    private array $startCreatures = [];
    /** @var array<int, string> */
    private array $grid = [];
    /** @var array<int, Creature> */
    private array $creatures = [];

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
        // ---------- Parse input
        $this->maxY = count($input);
        $this->maxX = strlen($input[0] ?? '');
        $this->startGrid = $input;
        $this->startCreatures = [];
        $id = 0;
        for ($y = 0; $y < $this->maxY; ++$y) {
            for ($x = 0; $x < $this->maxX; ++$x) {
                $char = $this->startGrid[$y][$x] ?? ' ';
                if (isset(Creature::CHAR_TO_TEAM[$char])) {
                    $this->startCreatures[$id] = new Creature($id, Creature::CHAR_TO_TEAM[$char], $x, $y);
                    ++$id;
                }
            }
        }
        if (count($this->startCreatures) == 0) {
            throw new \Exception('Invalid input');
        }
        // ---------- Part 1
        $this->grid = $this->startGrid;
        $this->creatures = array_map(
            static fn (Creature $creature): Creature => clone $creature,
            $this->startCreatures
        );
        [$turn, $totalHp, $elvesDied] = $this->simulate();
        $ans1 = $turn * $totalHp;
        // ---------- Part 2
        $ans2 = 0;
        $elfAttack = 4;
        while (true) {
            $this->grid = $this->startGrid;
            $this->creatures = array_map(
                static fn (Creature $creature): Creature => clone $creature,
                $this->startCreatures
            );
            [$turn, $totalHp, $elvesDied] = $this->simulate($elfAttack);
            if ($elvesDied == 0) {
                $ans2 = $turn * $totalHp;
                break;
            }
            ++$elfAttack;
        }
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @return array<int, int> [$turn, $totalHp, $elvesDied]
     */
    private function simulate(int $elfAttack = 3): array
    {
        $aliveCreatures = $this->creatures;
        $turn = 0;
        $elvesDied = 0;
        $winnerSide = '';
        $survivors = [];
        // @phpstan-ignore-next-line
        if (self::DEBUG and ($elfAttack == 3)) {
            // @codeCoverageIgnoreStart
            echo '---- Starting state', PHP_EOL;
            foreach ($this->grid as $line) {
                echo $line, PHP_EOL;
            }
            foreach ($aliveCreatures as $c) {
                echo $c->toString(), PHP_EOL;
            }
            // @codeCoverageIgnoreEnd
        }
        while (true) {
            // eliminate killed creatures
            $aliveCreatures = array_filter(
                $aliveCreatures,
                static fn (Creature $c): bool => $c->hp > 0,
            );
            for ($type = 0; $type <= 1; ++$type) {
                $sides[$type] = array_filter(
                    $aliveCreatures,
                    static fn (Creature $c): bool => $c->type == $type,
                );
            }
            // move or attack order
            uasort($aliveCreatures, static function (Creature $a, Creature $b): int {
                $result = $a->y <=> $b->y;
                if ($result != 0) {
                    return $result;
                }
                return $a->x <=> $b->x;
            });
            foreach ($aliveCreatures as $attacker) {
                if ($attacker->hp == 0) {
                    continue;
                }
                // check winning condition
                if (count($sides[1 - $attacker->type]) == 0) {
                    $survivors = $sides[$attacker->type];
                    $winnerSide = Creature::TEAM_TO_CHAR[$attacker->type];
                    break 2;
                }
                $inRangeEnemies = array_filter(
                    $sides[1 - $attacker->type],
                    static fn (Creature $c): bool => (($c->x == $attacker->x) and (abs($c->y - $attacker->y) == 1))
                        or (($c->y == $attacker->y) and (abs($c->x - $attacker->x) == 1)),
                );
                if (count($inRangeEnemies) == 0) {
                    // select move target
                    // hash must be increasing in reading order
                    $hash = ($attacker->y << 16) | $attacker->x;
                    $visited = [$hash => true];
                    $prev = [$hash => -1];
                    $shortestInRangeDist = PHP_INT_MAX;
                    $shortestInRangeNodes = [];
                    $q = [[$attacker->x, $attacker->y, 0]];
                    $readIdx = 0;
                    while ($readIdx < count($q)) {
                        [$x, $y, $step] = $q[$readIdx];
                        $hash = ($y << 16) | $x;
                        ++$readIdx;
                        // DELTA_XY must iterated in reading order
                        foreach ([[0, -1], [-1, 0], [1, 0], [0, 1]] as [$dx, $dy]) {
                            $x1 = $x + $dx;
                            $y1 = $y + $dy;
                            if (($x1 < 0) or ($x1 >= $this->maxX) or ($y1 < 0) or ($y1 >= $this->maxY)) {
                                continue;
                            }
                            if ($this->grid[$y1][$x1] != self::EMPTY) {
                                continue;
                            }
                            $hash1 = ($y1 << 16) | $x1;
                            if (isset($visited[$hash1])) {
                                continue;
                            }
                            $inRangeEnemies = array_filter(
                                $sides[1 - $attacker->type],
                                static fn (Creature $c): bool => (($c->x == $x1) and (abs($c->y - $y1) == 1))
                                    or (($c->y == $y1) and (abs($c->x - $x1) == 1)),
                            );
                            if (count($inRangeEnemies) != 0) {
                                if ($step + 1 < $shortestInRangeDist) {
                                    $shortestInRangeDist = $step + 1;
                                    $shortestInRangeNodes = [$hash1];
                                } elseif ($step + 1 == $shortestInRangeDist) {
                                    $shortestInRangeNodes[] = $hash1;
                                }
                            }
                            $visited[$hash1] = true;
                            $prev[$hash1] = $hash;
                            $q[] = [$x1, $y1, $step + 1];
                        }
                        sort($shortestInRangeNodes);
                        if (count($shortestInRangeNodes) != 0) {
                            // target cell
                            $hash = $shortestInRangeNodes[0];
                            while (($prev[$hash] != -1) and ($prev[$prev[$hash]] != -1)) {
                                $hash = $prev[$hash];
                            }
                            // move towards target
                            $this->grid[$attacker->y][$attacker->x] = self::EMPTY;
                            $x = $hash & ((1 << 16) - 1);
                            $y = $hash >> 16;
                            $attacker->x = $x;
                            $attacker->y = $y;
                            $this->grid[$y][$x] = Creature::TEAM_TO_CHAR[$attacker->type];
                        }
                    }
                    $inRangeEnemies = array_filter(
                        $sides[1 - $attacker->type],
                        static fn (Creature $c): bool => (($c->x == $attacker->x) and (abs($c->y - $attacker->y) == 1))
                            or (($c->y == $attacker->y) and (abs($c->x - $attacker->x) == 1)),
                    );
                }
                if (count($inRangeEnemies) == 0) {
                    continue;
                }
                // select attack target
                usort($inRangeEnemies, static function (Creature $a, Creature $b): int {
                    $result = $a->hp <=> $b->hp;
                    if ($result != 0) {
                        return $result;
                    }
                    $result = $a->y <=> $b->y;
                    if ($result != 0) {
                        return $result;
                    }
                    return $a->x <=> $b->y;
                });
                $defender = $inRangeEnemies[0];
                // attack
                $damage = $attacker->type == Creature::ELF ? $elfAttack : Creature::ATTACK;
                $defender->hp = intval(max(0, $defender->hp - $damage));
                if ($defender->hp == 0) {
                    if ($defender->type == Creature::ELF) {
                        ++$elvesDied;
                    }
                    $this->grid[$defender->y][$defender->x] = self::EMPTY;
                    unset($sides[1 - $attacker->type][$defender->id]);
                }
            }
            ++$turn;
        }
        $totalHp = array_sum(array_map(
            static fn (Creature $c): int => $c->hp,
            $survivors,
        ));
        // @phpstan-ignore-next-line
        if (self::DEBUG) {
            // @codeCoverageIgnoreStart
            echo '-- With ' . $elfAttack . ' elf attack power: ' . $elvesDied . ' elves died. Winner team is '
                . $winnerSide . ', after ' . $turn . ' turns, with ' , $totalHp . ' total HP.', PHP_EOL;
            if (($elfAttack == 3) or ($elvesDied == 0)) {
                echo '---- Final state', PHP_EOL;
                foreach ($this->grid as $line) {
                    echo $line, PHP_EOL;
                }
                foreach ($aliveCreatures as $c) {
                    echo $c->toString(), PHP_EOL;
                }
            }
            // @codeCoverageIgnoreEnd
        }
        return [$turn, $totalHp, $elvesDied];
    }
}

// --------------------------------------------------------------------
final class Creature
{
    public const START_HP = 200;
    public const ATTACK = 3;
    public const ELF = 0;
    public const GOBLIN = 1;
    public const CHAR_TO_TEAM = ['E' => self::ELF, 'G' => self::GOBLIN];
    public const TEAM_TO_CHAR = [self::ELF => 'E', self::GOBLIN => 'G'];

    public int $x;
    public int $y;
    public int $hp;

    public function __construct(
        public readonly int $id = 0,
        public readonly int $type = self::ELF,
        public readonly int $startX = 0,
        public readonly int $startY = 0,
    ) {
        $this->x = $startX;
        $this->y = $startY;
        $this->hp = self::START_HP;
    }

    /**
     * @codeCoverageIgnore
     */
    public function toString(): string
    {
        return '#' . $this->id . ' [' . (self::TEAM_TO_CHAR[$this->type] ?? '?')
            . ']; hp: ' . $this->hp . '/' . self::START_HP
            . '; @' . $this->x . ',' . $this->y . ' [started at: ' . $this->startX . ',' . $this->startY . ']';
    }
}

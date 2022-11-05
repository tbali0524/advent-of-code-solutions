<?php

// phpcs:disable PSR1.Classes.ClassDeclaration

declare(strict_types=1);

namespace TBali\Aoc2015;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2015 Day 22: Wizard Simulator 20XX.
 *
 * Part 1: What is the least amount of mana you can spend and still win the fight?
 * Part 2: At the start of each player turn (before any other effects apply), you lose 1 hit point.
 *         What is the least amount of mana you can spend and still win the fight?
 *
 * Topics: game simulation, DFS, graph, PriorityQueue
 *
 * @see https://adventofcode.com/2015/day/22
 */
final class Aoc2015Day22 extends SolutionBase
{
    public const YEAR = 2015;
    public const DAY = 22;
    public const TITLE = 'Wizard Simulator 20XX';
    public const SOLUTIONS = [900, 1216];

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
        $ans1 = (new WizardSimulator(...$processedInput))->simulate();
        $ans2 = (new WizardSimulatorHardMode(...$processedInput))->simulate();
        return [strval($ans1), strval($ans2)];
    }
}

// --------------------------------------------------------------------
final class WizardGameState
{
    private const PLAYER_START_HP = 50;
    private const PLAYER_START_MANA = 500;
    // note: cannot use enums as array keys, so using an int code instead
    private const SPELL_MAGIC_MISSILE = 0;
    private const SPELL_DRAIN = 1;
    private const SPELL_SHIELD = 2;
    private const SPELL_POISON = 3;
    private const SPELL_RECHARGE = 4;
    private const SPELLS = [
        self::SPELL_MAGIC_MISSILE,
        self::SPELL_DRAIN,
        self::SPELL_SHIELD,
        self::SPELL_POISON,
        self::SPELL_RECHARGE,
    ];
    private const SPELL_COSTS = [
        self::SPELL_MAGIC_MISSILE => 53,
        self::SPELL_DRAIN => 73,
        self::SPELL_SHIELD => 113,
        self::SPELL_POISON => 173,
        self::SPELL_RECHARGE => 229,
    ];
    private const SPELL_DURATIONS = [
        self::SPELL_MAGIC_MISSILE => 0,
        self::SPELL_DRAIN => 0,
        self::SPELL_SHIELD => 6,
        self::SPELL_POISON => 6,
        self::SPELL_RECHARGE => 5,
    ];
    private const SPELL_VALUES = [
        self::SPELL_MAGIC_MISSILE => 4,
        self::SPELL_DRAIN => 2,
        self::SPELL_SHIELD => 7,
        self::SPELL_POISON => 3,
        self::SPELL_RECHARGE => 101,
    ];

    public int $enemyHp;
    public readonly int $enemyDamage;
    public readonly bool $hardMode;

    public int $hp = self::PLAYER_START_HP;
    public int $mana = self::PLAYER_START_MANA;
    public int $spentMana = 0;
    public int $armor = 0;
    /** @var array<int, int> */
    public array $timers = [];

    public function __construct(int $enemyHp, int $enemyDamage, bool $hardMode = false)
    {
        $this->enemyHp = $enemyHp;
        $this->enemyDamage = $enemyDamage;
        $this->hardMode = $hardMode;
    }

    /** @return array<int, int> */
    public function allValidSpells(): array
    {
        if (($this->enemyHp <= 0) or ($this->hp <= 0)) {
            return [];
        }
        $spells = [];
        foreach (self::SPELLS as $spell) {
            if ($this->mana < self::SPELL_COSTS[$spell]) {
                continue;
            }
            if (($this->timers[$spell] ?? 1) > 1) {
                continue;
            }
            $spells[] = $spell;
        }
        return $spells;
    }

    // simulates a full Player turn (with casting $spell) and also a Boss turn
    public function applyMove(int $spell): void
    {
        if (
            !isset(self::SPELL_COSTS[$spell])
            or ($this->mana < self::SPELL_COSTS[$spell])
            or (($this->timers[$spell] ?? 1) > 1)
        ) {
            throw new \Exception('Tried to invoke invalid spell, or spell still in effect or with insufficient mana');
        }
        // Player turn
        if ($this->hardMode) {
            --$this->hp;
            if ($this->hp <= 0) {
                return;
            }
        }
        $this->applyEffects();
        if ($this->enemyHp <= 0) {
            return;
        }
        $this->mana -= self::SPELL_COSTS[$spell];
        $this->spentMana += self::SPELL_COSTS[$spell];
        if ($spell == self::SPELL_MAGIC_MISSILE) {
            $this->enemyHp = max(0, $this->enemyHp - self::SPELL_VALUES[self::SPELL_MAGIC_MISSILE]);
        } elseif ($spell == self::SPELL_DRAIN) {
            $this->hp += self::SPELL_VALUES[self::SPELL_DRAIN];
            $this->enemyHp = max(0, $this->enemyHp - self::SPELL_VALUES[self::SPELL_DRAIN]);
        }
        if ((self::SPELL_DURATIONS[$spell] ?? 0) > 0) {
            $this->timers[$spell] = self::SPELL_DURATIONS[$spell];
        }
        if ($this->enemyHp <= 0) {
            return;
        }
        // Boss turn
        $this->applyEffects();
        if ($this->enemyHp <= 0) {
            return;
        }
        $shield = ($this->timers[self::SPELL_SHIELD] ?? 0) > 0 ? self::SPELL_VALUES[self::SPELL_SHIELD] : 0;
        $this->hp = max(0, $this->hp - max(1, $this->enemyDamage - $this->armor - $shield));
    }

    public function applyEffects(): void
    {
        foreach ($this->timers as $spell => $timer) {
            if ($timer == 0) {
                continue;
            }
            if ($spell == self::SPELL_POISON) {
                $this->enemyHp = max(0, $this->enemyHp - self::SPELL_VALUES[self::SPELL_POISON]);
            } elseif ($spell == self::SPELL_RECHARGE) {
                $this->mana += self::SPELL_VALUES[self::SPELL_RECHARGE];
            }
            --$this->timers[$spell];
        }
    }
}

// --------------------------------------------------------------------
class WizardSimulator
{
    public WizardGameState $startState;
    /** @var \SplPriorityQueue<int, WizardGameState> */
    public \SplPriorityQueue $q;

    public function __construct(int $enemyHp, int $enemyDamage)
    {
        $this->startState = new WizardGameState($enemyHp, $enemyDamage);
        $this->q = new \SplPriorityQueue();
    }

    public function simulate(): int
    {
        $this->q->insert($this->startState, 0);
        while (true) {
            if ($this->q->isEmpty()) {
                throw new \Exception('No solution found');
            }
            $currentState = $this->q->extract();
            if (!$currentState instanceof WizardGameState) {
                throw new \Exception('Invalid object in queue');
            }
            if ($currentState->enemyHp <= 0) {
                return $currentState->spentMana;
            }
            $spells = $currentState->allValidSpells();
            foreach ($spells as $spell) {
                $nextState = clone $currentState;
                $nextState->applyMove($spell);
                $this->q->insert($nextState, -$nextState->spentMana);
            }
        }
    }
}

// --------------------------------------------------------------------
final class WizardSimulatorHardMode extends WizardSimulator
{
    public function __construct(int $enemyHp, int $enemyDamage)
    {
        $this->startState = new WizardGameState($enemyHp, $enemyDamage, true);
        $this->q = new \SplPriorityQueue();
    }
}

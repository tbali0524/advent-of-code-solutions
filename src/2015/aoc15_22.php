<?php

/*
https://adventofcode.com/2015/day/22
Part 1: What is the least amount of mana you can spend and still win the fight?
Part 2: At the start of each player turn (before any other effects apply), you lose 1 hit point.
    What is the least amount of mana you can spend and still win the fight?
topics: DFS, PriorityQueue
*/

// phpcs:disable PSR1.Files.SideEffects, PSR1.Classes.ClassDeclaration

declare(strict_types=1);

namespace TBali\Aoc15_22;

// --------------------------------------------------------------------
const YEAR = 2015;
const DAY = '22';
const TITLE = 'Wizard Simulator 20XX';
const SOLUTION1 = 900;
const SOLUTION2 = 1216;
$startTime = hrtime(true);
// ----------
$handle = fopen('input/' . YEAR . '/aoc15_22.txt', 'r');
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
// Part 1 + 2
const PLAYER_START_HP = 50;
const PLAYER_START_MANA = 500;
// note: cannot use enums as array keys, so using an int code instead
const SPELL_MAGIC_MISSILE = 0;
const SPELL_DRAIN = 1;
const SPELL_SHIELD = 2;
const SPELL_POISON = 3;
const SPELL_RECHARGE = 4;
const SPELLS = [SPELL_MAGIC_MISSILE, SPELL_DRAIN, SPELL_SHIELD, SPELL_POISON, SPELL_RECHARGE];
const SPELL_COSTS = [
    SPELL_MAGIC_MISSILE => 53,
    SPELL_DRAIN => 73,
    SPELL_SHIELD => 113,
    SPELL_POISON => 173,
    SPELL_RECHARGE => 229,
];
const SPELL_DURATIONS = [
    SPELL_MAGIC_MISSILE => 0,
    SPELL_DRAIN => 0,
    SPELL_SHIELD => 6,
    SPELL_POISON => 6,
    SPELL_RECHARGE => 5,
];
const SPELL_VALUES = [
    SPELL_MAGIC_MISSILE => 4,
    SPELL_DRAIN => 2,
    SPELL_SHIELD => 7,
    SPELL_POISON => 3,
    SPELL_RECHARGE => 101,
];
$ans1 = (new WizardSimulator(...$input))->simulate();
$ans2 = (new WizardSimulatorHardMode(...$input))->simulate();
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
class GameState
{
    public int $enemyHp;
    public int $enemyDamage;
    public bool $hardMode;

    public int $hp = PLAYER_START_HP;
    public int $mana = PLAYER_START_MANA;
    public int $spentMana = 0;
    public int $armor = 0;

    /** @var int[] */
    public array $timers = [];

    public function __construct(int $enemyHp, int $enemyDamage, bool $hardMode = false)
    {
        $this->enemyHp = $enemyHp;
        $this->enemyDamage = $enemyDamage;
        $this->hardMode = $hardMode;
    }

    /** @return int[] */
    public function allValidSpells(): array
    {
        if (($this->enemyHp <= 0) or ($this->hp <= 0)) {
            return [];
        }
        $spells = [];
        foreach (SPELLS as $spell) {
            if ($this->mana < SPELL_COSTS[$spell]) {
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
            !isset(SPELL_COSTS[$spell])
            or ($this->mana < SPELL_COSTS[$spell])
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
        $this->mana -= SPELL_COSTS[$spell];
        $this->spentMana += SPELL_COSTS[$spell];
        if ($spell == SPELL_MAGIC_MISSILE) {
            $this->enemyHp = max(0, $this->enemyHp - SPELL_VALUES[SPELL_MAGIC_MISSILE]);
        } elseif ($spell == SPELL_DRAIN) {
            $this->hp += SPELL_VALUES[SPELL_DRAIN];
            $this->enemyHp = max(0, $this->enemyHp - SPELL_VALUES[SPELL_DRAIN]);
        }
        if ((SPELL_DURATIONS[$spell] ?? 0) > 0) {
            $this->timers[$spell] = SPELL_DURATIONS[$spell];
        }
        if ($this->enemyHp <= 0) {
            return;
        }
        // Boss turn
        $this->applyEffects();
        if ($this->enemyHp <= 0) {
            return;
        }
        $shield = ($this->timers[SPELL_SHIELD] ?? 0) > 0 ? SPELL_VALUES[SPELL_SHIELD] : 0;
        $this->hp = max(0, $this->hp - max(1, $this->enemyDamage - $this->armor - $shield));
    }

    public function applyEffects(): void
    {
        foreach ($this->timers as $spell => $timer) {
            if ($timer == 0) {
                continue;
            }
            if ($spell == SPELL_POISON) {
                $this->enemyHp = max(0, $this->enemyHp - SPELL_VALUES[SPELL_POISON]);
            } elseif ($spell == SPELL_RECHARGE) {
                $this->mana += SPELL_VALUES[SPELL_RECHARGE];
            }
            --$this->timers[$spell];
        }
    }
}

// --------------------------------------------------------------------
class WizardSimulator
{
    public GameState $startState;
    /** @var \SplPriorityQueue<int, GameState> */
    public \SplPriorityQueue $q;

    public function __construct(int $enemyHp, int $enemyDamage)
    {
        $this->startState = new GameState($enemyHp, $enemyDamage);
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
            if (!$currentState instanceof GameState) {
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
class WizardSimulatorHardMode extends WizardSimulator
{
    public function __construct(int $enemyHp, int $enemyDamage)
    {
        $this->startState = new GameState($enemyHp, $enemyDamage, true);
        $this->q = new \SplPriorityQueue();
    }
}

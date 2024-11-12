<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2018;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2018 Day 24: Immune System Simulator 20XX.
 *
 * Part 1: As it stands now, how many units would the winning army have?
 * Part 2: How many units does the immune system have left after getting the smallest boost it needs to win?
 *
 * Topics: string parsing, game simulation
 *
 * @see https://adventofcode.com/2018/day/24
 *
 * @codeCoverageIgnore
 */
final class Aoc2018Day24 extends SolutionBase
{
    public const YEAR = 2018;
    public const DAY = 24;
    public const TITLE = 'Immune System Simulator 20XX';
    public const SOLUTIONS = [22859, 2834];
    public const EXAMPLE_SOLUTIONS = [[5216, 51]];

    private const DEBUG = false;

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
        $groups = [];
        $type = ArmyGroup::IMMUNE_SYSTEM;
        $id = 0;
        foreach ($input as $line) {
            if ($line == 'Immune System:') {
                $type = ArmyGroup::IMMUNE_SYSTEM;
                continue;
            }
            if ($line == 'Infection:') {
                $type = ArmyGroup::INFECTION;
                continue;
            }
            if (strlen($line) == 0) {
                continue;
            }
            $groups[$id] = ArmyGroup::fromString($line, $id, $type);
            ++$id;
        }
        // ---------- Part 1
        $clonedGroups = array_map(static fn (ArmyGroup $g): ArmyGroup => clone $g, $groups);
        $survivors = $this->simulate($clonedGroups);
        $ans1 = array_sum(array_map(
            static fn (ArmyGroup $g): int => $g->units,
            $survivors,
        ));
        // ---------- Part 2
        $boost = 0;
        while (true) {
            ++$boost;
            $clonedGroups = array_map(static fn (ArmyGroup $g): ArmyGroup => clone $g, $groups);
            foreach ($clonedGroups as $g) {
                if ($g->type == ArmyGroup::IMMUNE_SYSTEM) {
                    $g->damage += $boost;
                }
            }
            $survivors = $this->simulate($clonedGroups);
            if (count($survivors) == 0) {
                continue;
            }
            if ($survivors[0]->type == ArmyGroup::IMMUNE_SYSTEM) {
                break;
            }
        }
        $ans2 = array_sum(array_map(
            static fn (ArmyGroup $g): int => $g->units,
            $survivors,
        ));
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param array<int, ArmyGroup> $groups
     *
     * @return array<int, ArmyGroup> The surviving groups of the winner team, or [] if draw
     */
    private function simulate(array $groups): array
    {
        $aliveGroups = $groups;
        $totalKills = 0;
        $sides = [];
        while (true) {
            // eliminate killed groups
            $aliveGroups = array_filter(
                $aliveGroups,
                static fn (ArmyGroup $g): bool => $g->units > 0,
            );
            for ($type = 0; $type <= 1; ++$type) {
                $sides[$type] = array_filter(
                    $aliveGroups,
                    static fn (ArmyGroup $g): bool => $g->type == $type,
                );
            }
            // check winning condition
            if (count($sides[ArmyGroup::IMMUNE_SYSTEM]) == 0) {
                break;
            }
            if (count($sides[ArmyGroup::INFECTION]) == 0) {
                break;
            }
            // targeting phase
            foreach ($aliveGroups as $g) {
                $g->targeting = ArmyGroup::NONE;
                $g->targetedBy = ArmyGroup::NONE;
            }
            usort($aliveGroups, static function (ArmyGroup $a, ArmyGroup $b): int {
                $result = $b->units * $b->damage <=> $a->units * $a->damage;
                if ($result != 0) {
                    return $result;
                }
                return $b->initiative <=> $a->initiative;
            });
            foreach ($aliveGroups as $attacker) {
                $candidates = array_filter(
                    $sides[1 - $attacker->type],
                    static fn (ArmyGroup $g): bool => $g->targetedBy == ArmyGroup::NONE,
                );
                usort($candidates, static function (ArmyGroup $a, ArmyGroup $b) use ($attacker): int {
                    $result = $attacker->calculateDamage($b) <=> $attacker->calculateDamage($a);
                    if ($result != 0) {
                        return $result;
                    }
                    $result = $b->units * $b->damage <=> $a->units * $a->damage;
                    if ($result != 0) {
                        return $result;
                    }
                    return $b->initiative <=> $a->initiative;
                });
                if (count($candidates) == 0) {
                    continue;
                }
                $defender = $candidates[0];
                $damage = $attacker->calculateDamage($defender);
                if ($damage == 0) {
                    continue;
                }
                $attacker->targeting = $defender->id;
                $defender->targetedBy = $attacker->id;
            }
            // attacking phase
            usort($aliveGroups, static fn (ArmyGroup $a, ArmyGroup $b): int => $b->initiative <=> $a->initiative);
            // @phpstan-ignore if.alwaysFalse
            if (self::DEBUG) {
                echo '---- starting attacking phase', PHP_EOL;
                foreach ($aliveGroups as $g) {
                    echo $g->toString(), PHP_EOL;
                }
            }
            $totalKills = 0;
            foreach ($aliveGroups as $attacker) {
                if ($attacker->units == 0) {
                    continue;
                }
                if ($attacker->targeting == ArmyGroup::NONE) {
                    continue;
                }
                $defender = $groups[$attacker->targeting];
                $damage = $attacker->calculateDamage($defender);
                $killed = intval(min(intdiv($damage, $defender->hp), $defender->units));
                $totalKills += $killed;
                $defender->units -= $killed;
                // @phpstan-ignore if.alwaysFalse
                if (self::DEBUG) {
                    // @codeCoverageIgnoreStart
                    echo '  #' . $attacker->id . ' hits #' . $defender->id
                        . '; damage: ' . $damage . '; killed: ' . $killed
                        . ($defender->units == 0 ? ' (eliminated)' : ''), PHP_EOL;
                    // @codeCoverageIgnoreEnd
                }
            }
            if ($totalKills == 0) {
                break;
            }
        }
        // @phpstan-ignore if.alwaysFalse
        if (self::DEBUG) {
            // @codeCoverageIgnoreStart
            echo '-------- surviving groups', PHP_EOL;
            foreach ($aliveGroups as $g) {
                echo $g->toString(), PHP_EOL;
            }
            // @codeCoverageIgnoreEnd
        }
        if ($totalKills == 0) {
            return [];
        }
        return array_values($aliveGroups);
    }
}

// --------------------------------------------------------------------
/**
 * @codeCoverageIgnore
 */
final class ArmyGroup
{
    public const IMMUNE_SYSTEM = 0;
    public const INFECTION = 1;
    public const NONE = -1;

    public int $id = 0;
    public int $type = self::IMMUNE_SYSTEM;
    public int $startUnits = 0;
    public int $hp = 0;
    /** @var array<int, string> */
    public array $weaknesses = [];
    /** @var array<int, string> */
    public array $immunities = [];
    public int $damage = 0;
    public string $damageType = '';
    public int $initiative = 0;

    public int $units = 0;
    public int $targeting = self::NONE;
    public int $targetedBy = self::NONE;

    public function calculateDamage(self $defender): int
    {
        if (in_array($this->damageType, $defender->immunities, true)) {
            return 0;
        }
        $multiplier = in_array($this->damageType, $defender->weaknesses, true) ? 2 : 1;
        return $this->units * $this->damage * $multiplier;
    }

    /**
     * @codeCoverageIgnore
     */
    public function toString(): string
    {
        return '#' . $this->id . ' [' . $this->type . ']; u:' . $this->units . '/' . $this->startUnits
            . '; T:' . $this->targeting . '/' . $this->targetedBy . '; hp:' . $this->hp
            . '; ini: ' . $this->initiative . '; dam=' . $this->damage . ' ' . $this->damageType
            . '; weak: [' . implode(',', $this->weaknesses)
            . ']; immune: [' . implode(',', $this->immunities) . ']';
    }

    public static function fromString(string $s, int $id, int $type): self
    {
        $g = new self();
        $g->id = $id;
        $g->type = $type;
        $openPar = strpos($s, '(');
        $closePar = strpos($s, ')');
        if (($openPar !== false) and ($closePar !== false)) {
            $sub = substr($s, $openPar + 1, $closePar - $openPar - 1);
            $parts = explode('; ', $sub);
            foreach ($parts as $subList) {
                $words = explode(' ', $subList);
                $list = array_slice($words, 2);
                $list = explode(', ', implode(' ', $list));
                match ($words[0]) {
                    'weak' => $g->weaknesses = $list,
                    'immune' => $g->immunities = $list,
                    default => throw new \Exception('Invalid input'),
                };
                if ((count($words) < 3) or ($words[1] != 'to')) {
                    throw new \Exception('Invalid input');
                }
            }
        } else {
            $pos = strpos($s, ' with an attack');
            if ($pos === false) {
                throw new \Exception('Invalid input');
            }
            $openPar = $pos + 1;
            $closePar = $pos - 1;
        }
        $sub = substr($s, 0, $openPar);
        $count1 = sscanf($sub, '%d units each with %d hit points ', $startUnits, $hp);
        $g->startUnits = intval($startUnits);
        $g->hp = intval($hp);
        $g->units = $g->startUnits;
        $sub = substr($s, $closePar + 1);
        $count2 = sscanf(
            $sub,
            ' with an attack that does %d %s damage at initiative %d',
            $damage,
            $damageType,
            $initiative
        );
        $g->damage = intval($damage);
        $g->damageType = strval($damageType);
        $g->initiative = intval($initiative);
        if (($count1 != 2) or ($count2 != 3)) {
            throw new \Exception('Invalid input');
        }
        return $g;
    }
}

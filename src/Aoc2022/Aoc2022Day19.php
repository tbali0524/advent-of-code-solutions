<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2022;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2022 Day 19: Not Enough Minerals.
 *
 * Part 1: Determine the quality level of each blueprint using the largest number of geodes it could produce
 *         in 24 minutes. What do you get if you add up the quality level of all of the blueprints in your list?
 * Part 2: Just determine the largest number of geodes you could open using each of the first three blueprints.
 *         What do you get if you multiply these numbers together?
 *
 * Topics: beam search
 *
 * @see https://adventofcode.com/2022/day/19
 *
 * @codeCoverageIgnore
 */
final class Aoc2022Day19 extends SolutionBase
{
    public const YEAR = 2022;
    public const DAY = 19;
    public const TITLE = 'Not Enough Minerals';
    public const SOLUTIONS = [1550, 18630];
    public const EXAMPLE_SOLUTIONS = [[33, 56 * 62]];

    private const MAX_MINUTES_PART1 = 24;
    private const MAX_MINUTES_PART2 = 32;
    /** Smaller beam width is faster, but might miss the solution. */
    private const BEAM_WIDTH = 8_000;

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
        $blueprints = [];
        foreach ($input as $line) {
            $blueprints[] = Blueprint::fromString($line);
        }
        // ---------- Part 1
        $ans1 = 0;
        foreach ($blueprints as $blueprint) {
            $startState = new MineState();
            $startState->b = $blueprint;
            $bestGeode = $this->solveBeamSearch($startState, self::MAX_MINUTES_PART1);
            $ans1 += $blueprint->id * $bestGeode;
        }
        // ---------- Part 2
        $ans2 = 1;
        $blueprints = array_slice($blueprints, 0, 3);
        foreach ($blueprints as $blueprint) {
            $startState = new MineState();
            $startState->b = $blueprint;
            $bestGeode = $this->solveBeamSearch($startState, self::MAX_MINUTES_PART2);
            $ans2 *= $bestGeode;
        }
        return [strval($ans1), strval($ans2)];
    }

    private function solveBeamSearch(MineState $startState, int $maxMinutes): int
    {
        $states = [$startState];
        for ($turn = 0; $turn < $maxMinutes; ++$turn) {
            $allNextStates = [];
            $visited = [];
            foreach ($states as $state) {
                for ($whatToBuild = 0; $whatToBuild < 5; ++$whatToBuild) {
                    $newState = $state->nextState($whatToBuild);
                    if ($newState === $state) {
                        continue;
                    }
                    $hash = $newState->hash();
                    if (isset($visited[$hash])) {
                        continue;
                    }
                    $allNextStates[] = $newState;
                    $visited[$hash] = true;
                }
            }
            usort($allNextStates, fn (MineState $a, MineState $b): int => $b->score <=> $a->score);
            $states = array_slice($allNextStates, 0, self::BEAM_WIDTH);
        }
        return $states[0]->geode;
    }
}

// --------------------------------------------------------------------
final class Blueprint
{
    public int $id = 0;
    public int $oreRobotOreCost = 0;
    public int $clayRobotOreCost = 0;
    public int $obsidianRobotOreCost = 0;
    public int $obsidianRobotClayCost = 0;
    public int $geodeRobotOreCost = 0;
    public int $geodeRobotObsidianCost = 0;

    public static function fromString(string $s): self
    {
        $b = new self();
        $count = sscanf(
            $s,
            'Blueprint %d: Each ore robot costs %d ore. Each clay robot costs %d ore. '
                . 'Each obsidian robot costs %d ore and %d clay. Each geode robot costs %d ore and %d obsidian.',
            $b->id,
            $b->oreRobotOreCost,
            $b->clayRobotOreCost,
            $b->obsidianRobotOreCost,
            $b->obsidianRobotClayCost,
            $b->geodeRobotOreCost,
            $b->geodeRobotObsidianCost,
        );
        if ($count != 7) {
            throw new \Exception('Invalid input');
        }
        return $b;
    }
}

// --------------------------------------------------------------------
/**
 * @codeCoverageIgnore
 */
final class MineState
{
    public Blueprint $b;
    public int $minute = 0;
    public int $ore = 0;
    public int $clay = 0;
    public int $obsidian = 0;
    public int $geode = 0;
    public int $oreRobot = 1;
    public int $clayRobot = 0;
    public int $obsidianRobot = 0;
    public int $geodeRobot = 0;
    public int $score = 0;

    /**
     * Generates next State after building a robot.
     *
     * If build is unsuccessful (not enough resource), it returns self.
     *
     * @param $whatToBuild encoded as 0=none, 1=oreRobot, 2=clayRobot, 3=obsidianRobot, 4=geodeRobot
     */
    public function nextState(int $whatToBuild): self
    {
        $newOre = $this->ore;
        $newClay = $this->clay;
        $newObsidian = $this->obsidian;
        switch ($whatToBuild) {
            case 0:
                break;
            case 1:
                $newOre -= $this->b->oreRobotOreCost;
                break;
            case 2:
                $newOre -= $this->b->clayRobotOreCost;
                break;
            case 3:
                $newOre -= $this->b->obsidianRobotOreCost;
                $newClay -= $this->b->obsidianRobotClayCost;
                break;
            case 4:
                $newOre -= $this->b->geodeRobotOreCost;
                $newObsidian -= $this->b->geodeRobotObsidianCost;
                break;
            default:
                throw new \Exception('Impossible');
        }
        if (($newOre < 0) or ($newClay < 0) or ($newObsidian < 0)) {
            return $this;
        }
        $newState = clone $this;
        ++$newState->minute;
        $newState->ore = $newOre + $this->oreRobot;
        $newState->clay = $newClay + $this->clayRobot;
        $newState->obsidian = $newObsidian + $this->obsidianRobot;
        $newState->geode += $this->geodeRobot;
        match ($whatToBuild) {
            1 => ++$newState->oreRobot,
            2 => ++$newState->clayRobot,
            3 => ++$newState->obsidianRobot,
            4 => ++$newState->geodeRobot,
            default => 0,
        };
        $newState->updateScore();
        return $newState;
    }

    public function hash(): int
    {
        return $this->ore
            | ($this->clay << 8)
            | ($this->obsidian << 16)
            | ($this->geode << 24)
            | ($this->oreRobot << 32)
            | ($this->clayRobot << 40)
            | ($this->obsidianRobot << 48)
            | ($this->geodeRobot << 56);
    }

    public function updateScore(): void
    {
        $this->score = $this->ore
            + ($this->clay << 2)
            + ($this->obsidian << 4)
            + ($this->geode << 14)
            + ($this->oreRobot << 6)
            + ($this->clayRobot << 8)
            + ($this->obsidianRobot << 10)
            + ($this->geodeRobot << 12);
    }
}

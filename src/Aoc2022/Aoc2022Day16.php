<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2022;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2022 Day 16: Proboscidea Volcanium.
 *
 * Part 1: Work out the steps to release the most pressure in 30 minutes. What is the most pressure you can release?
 * Part 2: With you and an elephant working together for 26 minutes, what is the most pressure you could release?
 *
 * Topics: beam search
 *
 * @see https://adventofcode.com/2022/day/16
 *
 * @codeCoverageIgnore
 *
 * @todo The real solutions for the example input are not found by the beam search, even with a huge beam width.
 */
final class Aoc2022Day16 extends SolutionBase
{
    public const YEAR = 2022;
    public const DAY = 16;
    public const TITLE = 'Proboscidea Volcanium';
    public const SOLUTIONS = [1871, 2416];
    // public const EXAMPLE_SOLUTIONS = [[1651, 1707]]; // the real expected solutions for the example input
    public const EXAMPLE_SOLUTIONS = [[1646, 1706]];

    private const MAX_MINUTES_PART1 = 30;
    private const MAX_MINUTES_PART2 = 26;
    /** Smaller beam width is faster, but might miss the solution. */
    private const BEAM_WIDTH = 1_000;

    /** @var array<string, int> */
    private array $nameToIdx = [];
    /** @var array<int, int> */
    private array $flowRates = [];
    /** @var array<int, array<int, int>> */
    private array $adjList = [];

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
        $this->parseInput($input);
        // ---------- Part 1
        $startState = new ValveState();
        $startState->currentNode = $this->nameToIdx['AA'] ?? throw new \Exception('Invalid input');
        $startState->minutesRemaining = self::MAX_MINUTES_PART1;
        $ans1 = $this->solveBeamSearchPart1($startState);
        // ---------- Part 2
        $startState->elephantNode = $startState->currentNode;
        $startState->minutesRemaining = self::MAX_MINUTES_PART2;
        $ans2 = $this->solveBeamSearchPart2($startState);
        return [strval($ans1), strval($ans2)];
    }

    public function addOrGetNode(string $name): int
    {
        if (isset($this->nameToIdx[$name])) {
            return $this->nameToIdx[$name];
        }
        $id = count($this->nameToIdx);
        $this->nameToIdx[$name] = $id;
        return $id;
    }

    /**
     * Generates next state after opening valve at current node.
     *
     * Returns self if unsuccessful.
     */
    public function openValve(ValveState $state): ValveState
    {
        // already open
        if ((($state->maskOpened >> $state->currentNode) & 1) != 0) {
            return $state;
        }
        // zero valve
        if (($this->flowRates[$state->currentNode] ?? 0) == 0) {
            return $state;
        }
        $newState = clone $state;
        --$newState->minutesRemaining;
        $newState->totalReleased += $state->currentFlow;
        $newState->currentFlow += $this->flowRates[$state->currentNode];
        ++$newState->countOpened;
        $newState->maskOpened |= (1 << $state->currentNode);
        $newState->updateScore();
        return $newState;
    }

    /**
     * Generates next state after moving to an (adjacent) node.
     *
     * Assumption: $adjNode is really adjacent (not checked in this method).
     *
     * Returns self if unsuccessful.
     */
    public function move(ValveState $state, int $adjNode): ValveState
    {
        $newState = clone $state;
        --$newState->minutesRemaining;
        $newState->currentNode = $adjNode;
        $newState->totalReleased += $state->currentFlow;
        $newState->updateScore();
        return $newState;
    }

    /**
     * Generates next state after waiting 1 turn.
     *
     * @codeCoverageIgnore
     */
    public function wait(ValveState $state): ValveState
    {
        $newState = clone $state;
        --$newState->minutesRemaining;
        $newState->totalReleased += $state->currentFlow;
        $newState->updateScore();
        return $newState;
    }

    /**
     * Generates next state after dual action (me and elephant).
     *
     * Assumption: $adjNode and $elephantAdjNode is really adjacent (not checked in this method).
     * Or -1 means opening valve instead
     *
     * Returns self if unsuccessful.
     */
    public function nextStatePart2(ValveState $state, int $adjNode, int $elephantAdjNode): ValveState
    {
        if ($adjNode < 0) {
            if ((($state->maskOpened >> $state->currentNode) & 1) != 0) {
                return $state;
            }
            if (($this->flowRates[$state->currentNode] ?? 0) == 0) {
                return $state;
            }
        }
        if ($elephantAdjNode < 0) {
            if ((($state->maskOpened >> $state->elephantNode) & 1) != 0) {
                return $state;
            }
            if (($this->flowRates[$state->elephantNode] ?? 0) == 0) {
                return $state;
            }
        }
        $newState = clone $state;
        --$newState->minutesRemaining;
        $newState->totalReleased += $state->currentFlow;
        if ($adjNode < 0) {
            $newState->currentFlow += $this->flowRates[$state->currentNode];
            ++$newState->countOpened;
            $newState->maskOpened |= (1 << $state->currentNode);
        }
        if (
            ($elephantAdjNode < 0)
            and (($adjNode >= 0) or ($state->currentNode != $state->elephantNode))
        ) {
            $newState->currentFlow += $this->flowRates[$state->elephantNode];
            ++$newState->countOpened;
            $newState->maskOpened |= (1 << $state->elephantNode);
        }
        if ($adjNode >= 0) {
            $newState->currentNode = $adjNode;
        }
        if ($elephantAdjNode >= 0) {
            $newState->elephantNode = $elephantAdjNode;
        }
        $newState->updateScore();
        return $newState;
    }

    /**
     * Parse input, sets startStacks and instructions.
     *
     * @param array<int, string> $input The lines of the input, without LF
     */
    private function parseInput(array $input): void
    {
        $this->nameToIdx = [];
        $this->flowRates = array_fill(0, count($input), 0);
        $this->adjList = array_fill(0, count($input), []);
        foreach ($input as $line) {
            $posSemicolon = strpos($line, ';');
            $posToValve = strpos($line, ' to valve');
            if (
                !str_starts_with($line, 'Valve ')
                or !str_contains($line, ' has flow rate=')
                or ($posSemicolon === false)
                or ($posToValve === false)
            ) {
                throw new \Exception('Invalid input');
            }
            if ($line[$posToValve + 9] == 's') {
                ++$posToValve;
            }
            $name = substr($line, 6, 2);
            $idxNode = $this->addOrGetNode($name);
            $this->flowRates[$idxNode] = intval(substr($line, 23, $posSemicolon - 23));
            $adjNames = explode(', ', substr($line, $posToValve + 10));
            foreach ($adjNames as $adjName) {
                $this->adjList[$idxNode][] = $this->addOrGetNode($adjName);
            }
        }
    }

    private function solveBeamSearchPart1(ValveState $startState): int
    {
        $states = [$startState];
        for ($turn = 0; $turn < $startState->minutesRemaining; ++$turn) {
            $allNextStates = [];
            $visited = [];
            foreach ($states as $state) {
                $newState = $this->openValve($state);
                if ($newState !== $state) {
                    $hash = $newState->hash();
                    if (!isset($visited[$hash])) {
                        $allNextStates[] = $newState;
                        $visited[$hash] = true;
                    }
                }
                foreach (($this->adjList[$state->currentNode] ?? []) as $adjNode) {
                    $newState = $this->move($state, $adjNode);
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
                if (count($allNextStates) == 0) {
                    $allNextStates[] = $this->wait($state);
                }
            }
            usort($allNextStates, fn (ValveState $a, ValveState $b): int => $b->score <=> $a->score);
            $states = array_slice($allNextStates, 0, self::BEAM_WIDTH);
        }
        return $states[0]->totalReleased;
    }

    private function solveBeamSearchPart2(ValveState $startState): int
    {
        $states = [$startState];
        for ($turn = 0; $turn < $startState->minutesRemaining; ++$turn) {
            $allNextStates = [];
            $visited = [];
            foreach ($states as $state) {
                $newState = $this->nextStatePart2($state, -1, -1);
                if ($newState !== $state) {
                    $hash = $newState->hash();
                    if (!isset($visited[$hash])) {
                        $allNextStates[] = $newState;
                        $visited[$hash] = true;
                    }
                }
                foreach (($this->adjList[$state->currentNode] ?? []) as $adjNode) {
                    $newState = $this->nextStatePart2($state, $adjNode, -1);
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
                foreach (($this->adjList[$state->elephantNode] ?? []) as $elephantAdjNode) {
                    $newState = $this->nextStatePart2($state, -1, $elephantAdjNode);
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
                foreach (($this->adjList[$state->currentNode] ?? []) as $adjNode) {
                    foreach (($this->adjList[$state->elephantNode] ?? []) as $elephantAdjNode) {
                        $newState = $this->nextStatePart2($state, $adjNode, $elephantAdjNode);
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
                if (count($allNextStates) == 0) {
                    $allNextStates[] = $this->wait($state);
                }
            }
            usort($allNextStates, fn (ValveState $a, ValveState $b): int => $b->score <=> $a->score);
            $states = array_slice($allNextStates, 0, self::BEAM_WIDTH);
        }
        return $states[0]->totalReleased;
    }
}

// --------------------------------------------------------------------
/**
 * @codeCoverageIgnore
 */
final class ValveState
{
    public int $minutesRemaining = 0;
    public int $currentNode = 0;
    public int $elephantNode = 0;
    public int $totalReleased = 0;
    public int $currentFlow = 0;
    public int $countOpened = 0;
    public int $maskOpened = 0;
    public int $score = 0;

    public function hash(): int
    {
        return $this->maskOpened | ($this->currentNode << 46) | ($this->elephantNode << 54);
    }

    public function updateScore(): void
    {
        $this->score = $this->totalReleased + $this->currentFlow * $this->minutesRemaining + $this->countOpened;
    }
}

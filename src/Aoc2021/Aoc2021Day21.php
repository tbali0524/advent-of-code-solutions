<?php

declare(strict_types=1);

namespace TBali\Aoc2021;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2021 Day 21: Dirac Dice.
 *
 * Part 1: What do you get if you multiply the score of the losing player
 *         by the number of times the die was rolled during the game?
 * Part 2: Find the player that wins in more universes; in how many universes does that player win?
 *
 * @see https://adventofcode.com/2021/day/21
 *
 * @codeCoverageIgnore
 */
final class Aoc2021Day21 extends SolutionBase
{
    public const YEAR = 2021;
    public const DAY = 21;
    public const TITLE = 'Dirac Dice';
    public const SOLUTIONS = [713328, 92399285032143];
    public const EXAMPLE_SOLUTIONS = [[739785, 444356092776315]];

    private const MAX_POS = 10;
    private const ROLLS_PER_MOVE = 3;
    private const DICE_SIDES_PART1 = 100;
    private const DICE_SIDES_PART2 = 3;
    private const WIN_SCORE_PART1 = 1000;
    private const WIN_SCORE_PART2 = 21;

    /**
     * @var array<string, array<int, int>>
     */
    private array $memo = [];

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
        if (count($input) != 2) {
            throw new \Exception('Invalid input');
        }
        $startPositions = [];
        for ($i = 0; $i < 2; ++$i) {
            $count = sscanf($input[$i] ?? '', 'Player %d starting position: %d', $player, $startPos);
            /** @var int $player */
            /** @var int $startPos */
            if (($count != 2) or !in_array($player, [1, 2]) or ($startPos < 1) or ($startPos > self::MAX_POS)) {
                throw new \Exception('Invalid input');
            }
            // transpose to 0-based player id and positions id.
            $startPositions[$player - 1] = $startPos - 1;
        }
        // ---------- Part 1
        $ans1 = 0;
        $countRolls = 0;
        $positions = $startPositions;
        $scores = [0, 0];
        while (true) {
            for ($player = 0; $player < 2; ++$player) {
                $sumRoll = 0;
                for ($i = 0; $i < self::ROLLS_PER_MOVE; ++$i) {
                    $roll = $countRolls % self::DICE_SIDES_PART1 + 1;
                    ++$countRolls;
                    $sumRoll += $roll;
                }
                $positions[$player] = ($positions[$player] + $sumRoll) % self::MAX_POS;
                $scores[$player] += $positions[$player] + 1;
                if ($scores[$player] >= self::WIN_SCORE_PART1) {
                    $ans1 = $countRolls * $scores[1 - $player];
                    break 2;
                }
            }
        }
        // ---------- Part 2
        $this->memo = [];
        $countWins = $this->countWins($startPositions);
        $ans2 = intval(max($countWins ?: [0]));
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param array<int, int> $positions
     * @param array<int, int> $scores
     *
     * @return array<int, int>
     */
    private function countWins(
        array $positions,
        array $scores = [0, 0],
        int $player = 0,
        int $idxRoll = 0,
        int $sumRoll = 0,
    ): array {
        $hash = $positions[0] . ' ' . $positions[1] . ' ' . $scores[0] . ' ' . $scores[1] . ' ' . $player
            . ' ' . $idxRoll . ' ' . $sumRoll;
        if (isset($this->memo[$hash])) {
            return $this->memo[$hash];
        }
        if ($scores[0] >= self::WIN_SCORE_PART2) {
            return [1, 0];
        }
        if ($scores[1] >= self::WIN_SCORE_PART2) {
            return [0, 1];
        }
        $ans = [0, 0];
        for ($roll = 1; $roll <= self::DICE_SIDES_PART2; ++$roll) {
            if ($idxRoll < self::ROLLS_PER_MOVE - 1) {
                $result = $this->countWins($positions, $scores, $player, $idxRoll + 1, $sumRoll + $roll);
                $ans[0] += $result[0];
                $ans[1] += $result[1];
                continue;
            }
            $newPositions = $positions;
            $newPositions[$player] = ($positions[$player] + $sumRoll + $roll) % self::MAX_POS;
            $newScores = $scores;
            $newScores[$player] += $newPositions[$player] + 1;
            $result = $this->countWins($newPositions, $newScores, 1 - $player, 0, 0);
            $ans[0] += $result[0];
            $ans[1] += $result[1];
        }
        $this->memo[$hash] = $ans;
        return $ans;
    }
}

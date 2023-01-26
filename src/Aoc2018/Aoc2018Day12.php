<?php

declare(strict_types=1);

namespace TBali\Aoc2018;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2018 Day 12: Subterranean Sustainability.
 *
 * Part 1: After 20 generations, what is the sum of the numbers of all pots which contain a plant?
 * Part 2: After fifty billion (50000000000) generations, what is the sum of the numbers of all pots
 *         which contain a plant?
 *
 * Topics: simulation, cycle detection
 *
 * @see https://adventofcode.com/2018/day/12
 */
final class Aoc2018Day12 extends SolutionBase
{
    public const YEAR = 2018;
    public const DAY = 12;
    public const TITLE = 'Subterranean Sustainability';
    public const SOLUTIONS = [3915, 4900000001793];
    public const EXAMPLE_SOLUTIONS = [[325, 0]];

    private const MAX_TURNS_PART1 = 20;
    private const MAX_TURNS_PART2 = 50_000_000_000;

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
        if ((count($input) < 3) or !str_starts_with($input[0], 'initial state: ') or ($input[1] != '')) {
            throw new \Exception('Invalid input');
        }
        $initState = substr($input[0], 15);
        for ($i = 2; $i < count($input); ++$i) {
            $a = explode(' => ', $input[$i]);
            if ((count($a) != 2) or (strlen($a[0]) != 5) or (strlen($a[1]) != 1)) {
                throw new \Exception('Invalid input');
            }
            $rules[$a[0]] = $a[1];
        }
        // ---------- Part 1 + 2
        $ans1 = 0;
        $state = $initState;
        $startPos = 0;
        $memo = [$state => [0, $startPos]];
        $foundCycle = false;
        for ($turn = 0; $turn < self::MAX_TURNS_PART2; ++$turn) {
            $extendedState = '....' . $state . '....';
            $newState = '';
            for ($i = 0; $i < strlen($extendedState) - 4; ++$i) {
                $prev = substr($extendedState, $i, 5);
                $newState .= ($rules[$prev] ?? '.');
            }
            $startPos -= 2;
            $to = strlen($newState) - 1;
            while (($to >= 0) and ($newState[$to] == '.')) {
                --$to;
            }
            $from = 0;
            while (($from < $to) and ($newState[$from] == '.')) {
                ++$from;
                ++$startPos;
            }
            $state = substr($newState, $from, $to - $from + 1);
            if ($turn == self::MAX_TURNS_PART1 - 1) {
                for ($i = 0; $i < strlen($state); ++$i) {
                    if ($state[$i] == '#') {
                        $ans1 += $i + $startPos;
                    }
                }
            }
            if ($turn < self::MAX_TURNS_PART1 - 1) {
                continue;
            }
            if ($foundCycle) {
                continue;
            }
            if (!isset($memo[$state])) {
                $memo[$state] = [$turn, $startPos];
                continue;
            }
            $foundCycle = true;
            [$prevTurn, $prevStartPos] = $memo[$state];
            $cycleLen = $turn - $prevTurn;
            $cycleCount = intdiv(self::MAX_TURNS_PART2 - $turn - 1, $cycleLen);
            $turn += $cycleCount * $cycleLen;
            $startPos += $cycleCount * ($startPos - $prevStartPos);
        }
        $ans2 = 0;
        for ($i = 0; $i < strlen($state); ++$i) {
            if ($state[$i] == '#') {
                $ans2 += $i + $startPos;
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}

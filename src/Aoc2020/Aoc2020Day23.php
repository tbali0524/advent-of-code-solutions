<?php

declare(strict_types=1);

namespace TBali\Aoc2020;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2020 Day 23: Crab Cups.
 *
 * Part 1: Using your labeling, simulate 100 moves. What are the labels on the cups after cup 1?
 * Part 2: Determine which two cups will end up immediately clockwise of cup 1.
 *         What do you get if you multiply their labels together?
 *
 * Topics: game simulation
 *
 * @see https://adventofcode.com/2020/day/23
 *
 * @codeCoverageIgnore
 */
final class Aoc2020Day23 extends SolutionBase
{
    public const YEAR = 2020;
    public const DAY = 23;
    public const TITLE = 'Crab Cups';
    public const SOLUTIONS = [47382659, 42271866720];
    public const STRING_INPUT = '364297581';
    public const EXAMPLE_SOLUTIONS = [[67384529, 149245887792]];
    public const EXAMPLE_STRING_INPUTS = ['389125467', ''];

    private const MAX_PART1 = 100;
    private const MAX_PART2 = 10_000_000;
    private const LEN_PART2 = 1_000_000;

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
        $cups = $input[0] ?? '0';
        // ---------- Part 1
        $ans1 = 0;
        $idxCurrent = 0;
        for ($step = 0; $step < self::MAX_PART1; ++$step) {
            $current = intval($cups[$idxCurrent]);
            $cups2 = $cups . $cups;
            $slice = substr($cups2, $idxCurrent + 1, 3);
            $dest = $current;
            while (true) {
                --$dest;
                if ($dest == 0) {
                    $dest = 9;
                }
                if (!str_contains($slice, strval($dest))) {
                    break;
                }
            }
            $cups = substr($cups2, $idxCurrent + 4, 6);
            $idxCurrent = 0;
            $idxDest = strpos($cups, strval($dest));
            if ($idxDest === false) {
                throw new \Exception('Impossible');
            }
            $cups = substr($cups, 0, $idxDest + 1) . $slice . substr($cups, $idxDest + 1);
        }
        $idxOne = strpos($cups, '1');
        if ($idxOne === false) {
            throw new \Exception('Impossible');
        }
        $ans1 = intval(substr($cups . $cups, $idxOne + 1, 8));
        // ---------- Part 2
        $cups = $input[0] ?? '0';
        $nextCup = range(1, self::LEN_PART2 + 1);
        $nextCup[0] = 0; // unused slot
        for ($i = 0; $i < strlen($cups) - 1; ++$i) {
            $nextCup[intval($cups[$i])] = intval($cups[$i + 1]);
        }
        $nextCup[intval($cups[strlen($cups) - 1])] = strlen($cups) + 1;
        $nextCup[self::LEN_PART2] = intval($cups[0]);
        $current = intval($cups[0]);
        for ($step = 0; $step < self::MAX_PART2; ++$step) {
            $sliceBegin = $nextCup[$current];
            $sliceMid = $nextCup[$sliceBegin];
            $sliceEnd = $nextCup[$sliceMid];
            $afterSlide = $nextCup[$sliceEnd];
            $nextCup[$current] = $afterSlide;
            $dest = $current;
            while (true) {
                --$dest;
                if ($dest == 0) {
                    $dest = self::LEN_PART2;
                }
                if (($dest != $sliceBegin) and ($dest != $sliceMid) and ($dest != $sliceEnd)) {
                    break;
                }
            }
            $afterDest = $nextCup[$dest];
            $nextCup[$dest] = $sliceBegin;
            $nextCup[$sliceEnd] = $afterDest;
            $current = $nextCup[$current];
        }
        $afterOne = $nextCup[1];
        $secondAfterOne = $nextCup[$afterOne];
        $ans2 = $afterOne * $secondAfterOne;
        return [strval($ans1), strval($ans2)];
    }
}

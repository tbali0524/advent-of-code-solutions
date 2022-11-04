<?php

// @TODO Part 2

/*
https://adventofcode.com/2020/day/23
Part 1: Using your labeling, simulate 100 moves. What are the labels on the cups after cup 1?
Part 2: Determine which two cups will end up immediately clockwise of cup 1.
    What do you get if you multiply their labels together?
Topics: game simulation
*/

// phpcs:disable PSR1.Classes.ClassDeclaration

declare(strict_types=1);

namespace TBali\Aoc2020;

use TBali\Aoc\SolutionBase;

final class Aoc2020Day23 extends SolutionBase
{
    public const YEAR = 2020;
    public const DAY = 23;
    public const TITLE = 'Crab Cups';
    public const SOLUTIONS = [47382659, 0];
    public const STRING_INPUT = '364297581';
    public const EXAMPLE_SOLUTIONS = [[67384529, 14924588779], [0, 0]];
    public const EXAMPLE_STRING_INPUTS = ['389125467', ''];

    private const MAX_PART1 = 100;
    private const MAX_PART2 = 10_000_000; // @phpstan-ignore-line
    private const LEN_PART2 = 1_000_000; // @phpstan-ignore-line

    /**
     * @param string[] $input
     *
     * @return array{string, string}
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
        $ans2 = 0;
        return [strval($ans1), strval($ans2)];
    }
}

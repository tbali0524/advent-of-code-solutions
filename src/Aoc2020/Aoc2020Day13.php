<?php

/*
https://adventofcode.com/2020/day/13
Part 1: What is the ID of the earliest bus you can take to the airport
    multiplied by the number of minutes you'll need to wait for that bus?
Part 2: What is the earliest timestamp such that all of the listed bus IDs depart at offsets
    matching their positions in the list?
Topics: Chinese Remainder Theorem, Bézout coefficients, GCD, extended Euclidean algorithm
*/

declare(strict_types=1);

namespace TBali\Aoc2020;

use TBali\Aoc\SolutionBase;

final class Aoc2020Day13 extends SolutionBase
{
    public const YEAR = 2020;
    public const DAY = 13;
    public const TITLE = 'Shuttle Search';
    public const SOLUTIONS = [261, 807435693182510];
    public const EXAMPLE_SOLUTIONS = [[295, 1068781], [0, 0]];

    /**
     * @param string[] $input
     *
     * @return array{string, string}
     */
    public function solve(array $input): array
    {
        if (count($input) != 2) {
            throw new \Exception('Invalid input');
        }
        $time = intval($input[0]);
        // ---------- Part 1
        $buses = $input = array_map(
            'intval',
            array_filter(
                explode(',', $input[1]),
                fn (string $x): bool => $x != 'x'
            )
        );
        if (count($buses) == 0) {
            throw new \Exception('Invalid input');
        }
        $idToWait = array_combine(
            $buses,
            array_map(
                fn (int $x): int => ($x - ($time % $x)) % $x,
                $buses
            )
        );
        asort($idToWait);
        $id = array_key_first($idToWait);
        $ans1 = $id * $idToWait[$id];
        // ---------- Part 2
        arsort($buses);
        $remainders = [];
        $modulos = [];
        foreach ($buses as $id => $bus) {
            $remainder = ($bus - $id) % $bus;
            if ($remainder < 0) {
                $remainder += $bus;
            }
            $remainders[] = $remainder;
            $modulos[] = $bus;
        }
        $from = $remainders[0];
        $step = $modulos[0];
        $cand = 0;
        for ($i = 1; $i < count($buses); ++$i) {
            $rem = $remainders[$i];
            $mod = $modulos[$i];
            $cand = $from;
            while (true) {
                if ($cand % $mod == $rem) {
                    break;
                }
                $cand += $step;
            }
            $from = $cand;
            $step *= $mod;
        }
        $ans2 = $cand;
        return [strval($ans1), strval($ans2)];
    }

    /**
     * Extended Euclidean algortihm (not used in this puzzle).
     *
     * Based on https://en.wikipedia.org/wiki/Extended_Euclidean_algorithm
     *
     * @return array{int, int, int} the greates common divisor, and the two Bézout coefficients
     */
    private static function extendedEuclidean(int $a, int $b): array
    {
        [$old_r, $r] = [$a, $b];
        [$old_s, $s] = [1, 0];
        [$old_t, $t] = [0, 1];
        while ($r != 0) {
            $quotient = intdiv($old_r, $r);
            [$old_r, $r] = [$r, $old_r - $quotient * $r];
            [$old_s, $s] = [$s, $old_s - $quotient * $s];
            [$old_t, $t] = [$t, $old_t - $quotient * $t];
        }
        return [$old_r, $old_s, $old_t];
    }
}

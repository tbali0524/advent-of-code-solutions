<?php

declare(strict_types=1);

namespace TBali\Aoc2017;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2017 Day 16: Permutation Promenade.
 *
 * Part 1: In what order are the programs standing after their dance?
 * Part 2: In what order are the programs standing after their billion dances?
 *
 * Topics: simulation, cycle detection
 *
 * @see https://adventofcode.com/2017/day/16
 */
final class Aoc2017Day16 extends SolutionBase
{
    public const YEAR = 2017;
    public const DAY = 16;
    public const TITLE = 'Permutation Promenade';
    public const SOLUTIONS = ['eojfmbpkldghncia', 'iecopnahgdflmkjb'];
    public const EXAMPLE_SOLUTIONS = [['baedc', 0]];

    public const MAX_STEPS_PART2 = 1_000_000_000;

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
        $instructions = explode(',', $input[0] ?? '');
        $commands = '';
        $op1 = [];
        $op2 = [];
        $op1s = [];
        $op2s = [];
        foreach ($instructions as $idx => $instr) {
            $commands .= $instr[0];
            $a = explode('/', substr($instr, 1));
            if ($instr[0] == 's') {
                $op1[$idx] = intval($a[0]);
            } elseif ($instr[0] == 'x') {
                $op1[$idx] = intval($a[0]);
                $op2[$idx] = intval($a[1]);
            } elseif ($instr[0] == 'p') {
                $op1s[$idx] = $a[0][0];
                $op2s[$idx] = $a[1][0];
            } else {
                throw new \Exception('Invalid input');
            }
        }
        $start = count($instructions) == 3 ? 'abcde' : 'abcdefghijklmnop';
        // ---------- Part 1
        $progs = $start;
        for ($i = 0; $i < strlen($commands); ++$i) {
            switch ($commands[$i]) {
                case 's':
                    $progs = substr($progs, -$op1[$i]) . substr($progs, 0, strlen($progs) - $op1[$i]);
                    break;
                case 'x':
                    $temp = $progs[$op1[$i]];
                    $progs[$op1[$i]] = $progs[$op2[$i]];
                    $progs[$op2[$i]] = $temp;
                    break;
                case 'p':
                    $pos1 = strpos($progs, $op1s[$i]);
                    $pos2 = strpos($progs, $op2s[$i]);
                    if (($pos1 === false) or ($pos2 === false)) {
                        // @codeCoverageIgnoreStart
                        throw new \Exception('Impossible');
                        // @codeCoverageIgnoreEnd
                    }
                    $temp = $progs[$pos1];
                    $progs[$pos1] = $progs[$pos2];
                    $progs[$pos2] = $temp;
                    break;
            }
        }
        $ans1 = $progs;
        // ---------- Part 2
        $progs = $start;
        $seenAt = [$start => 0];
        for ($turn = 1; $turn <= self::MAX_STEPS_PART2; ++$turn) {
            for ($i = 0; $i < strlen($commands); ++$i) {
                switch ($commands[$i]) {
                    case 's':
                        $progs = substr($progs, -$op1[$i]) . substr($progs, 0, strlen($progs) - $op1[$i]);
                        break;
                    case 'x':
                        $temp = $progs[$op1[$i]];
                        $progs[$op1[$i]] = $progs[$op2[$i]];
                        $progs[$op2[$i]] = $temp;
                        break;
                    case 'p':
                        $pos1 = strpos($progs, $op1s[$i]);
                        $pos2 = strpos($progs, $op2s[$i]);
                        if (($pos1 === false) or ($pos2 === false)) {
                            // @codeCoverageIgnoreStart
                            throw new \Exception('Impossible');
                            // @codeCoverageIgnoreEnd
                        }
                        $temp = $progs[$pos1];
                        $progs[$pos1] = $progs[$pos2];
                        $progs[$pos2] = $temp;
                        break;
                }
            }
            if (!isset($seenAt[$progs])) {
                $seenAt[$progs] = $turn;
                continue;
            }
            $cycleLen = $turn - $seenAt[$progs];
            $cycleCount = intdiv(self::MAX_STEPS_PART2 - $turn, $cycleLen);
            $turn += $cycleCount * $cycleLen;
        }
        $ans2 = $progs;
        return [strval($ans1), strval($ans2)];
    }
}

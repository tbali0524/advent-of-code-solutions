<?php

declare(strict_types=1);

namespace TBali\Aoc2016;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2016 Day 23: Safe Cracking.
 *
 * Part 1: What value should be sent to the safe?
 * Part 2: Anyway, what value should actually be sent to the safe?
 *
 * Topics: assembly simulation
 *
 * @see https://adventofcode.com/2016/day/23
 *
 * @todo Part 2 timeouts
 */
final class Aoc2016Day23 extends SolutionBase
{
    public const YEAR = 2016;
    public const DAY = 23;
    public const TITLE = 'Safe Cracking';
    public const SOLUTIONS = [13685, 0];
    public const EXAMPLE_SOLUTIONS = [[3, 0], [0, 0]];

    private const TOGGLE_MAP = [
        'inc' => 'dec',
        'dec' => 'inc',
        'tgl' => 'inc',
        'jnz' => 'cpy',
        'cpy' => 'jnz',
    ];

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
        // ---------- Part 1 + 2
        $ans1 = $this->execute($input, ['a' => 7, 'b' => 0, 'c' => 0, 'd' => 0])['a'] ?? 0;
        $ans2 = $this->execute($input, ['a' => 12, 'b' => 0, 'c' => 0, 'd' => 0])['a'] ?? 0;
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param array<int, string> $input     The lines of the input, without LF
     * @param array<string, int> $registers The registers at the start of execution
     *
     * @return array<string, int> The registers at the end of execution
     */
    private function execute(array $input, array $registers): array
    {
        $pc = -1;
        while (true) {
            ++$pc;
            if (($pc < 0) or ($pc >= count($input))) {
                return $registers;
            }
            $a = explode(' ', $input[$pc]);
            switch ($a[0]) {
                case 'cpy':
                    if ((count($a) != 3) or !isset($registers[$a[2]])) {
                        break;
                    }
                    $registers[$a[2]] = $registers[$a[1]] ?? intval($a[1]);
                    break;
                case 'inc':
                    if ((count($a) != 2) or !isset($registers[$a[1]])) {
                        break;
                    }
                    ++$registers[$a[1]];
                    break;
                case 'dec':
                    if ((count($a) != 2) or !isset($registers[$a[1]])) {
                        break;
                    }
                    --$registers[$a[1]];
                    break;
                case 'jnz':
                    if (count($a) != 3) {
                        break;
                    }
                    if (($registers[$a[1]] ?? intval($a[1])) != 0) {
                        $pc += ($registers[$a[2]] ?? intval($a[2])) - 1;
                    }
                    break;
                case 'tgl':
                    if (count($a) != 2) {
                        throw new \Exception('Invalid instruction');
                    }
                    $idxInst = $pc + ($registers[$a[1]] ?? intval($a[1]));
                    if (($idxInst < 0) or ($idxInst >= count($input))) {
                        break;
                    }
                    $instr = substr($input[$idxInst], 0, 3);
                    $input[$idxInst] = (self::TOGGLE_MAP[$instr] ?? $instr) . substr($input[$idxInst], 3);
                    break;
                default:
                    throw new \Exception('Invalid instruction');
            }
        }
    }
}

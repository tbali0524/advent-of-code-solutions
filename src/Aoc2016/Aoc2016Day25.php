<?php

declare(strict_types=1);

namespace TBali\Aoc2016;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2016 Day 25: Clock Signal.
 *
 * Part 1: What is the lowest positive integer that can be used to initialize register a and cause the code
 *         to output a clock signal of 0, 1, 0, 1... repeating forever?
 * Part 2: N/A
 *
 * Topics: assembly simulation
 *
 * @see https://adventofcode.com/2016/day/25
 *
 * @codeCoverageIgnore
 */
final class Aoc2016Day25 extends SolutionBase
{
    public const YEAR = 2016;
    public const DAY = 25;
    public const TITLE = 'Clock Signal';
    public const SOLUTIONS = [192, 0];

    /** @var array<int, string> */
    private array $instructions = [];

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
        // ---------- Part 1
        $this->instructions = $input;
        $ans1 = 1;
        while (!$this->execute($ans1)) {
            ++$ans1;
        }
        $ans2 = 0;
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param int $aRegister The initial value of register 'a' (rest are always 0)
     *
     * @return bool Was an infinite clock signal generating code discovered
     */
    private function execute(int $aRegister): bool
    {
        $registers = ['a' => $aRegister, 'b' => 0, 'c' => 0, 'd' => 0];
        $output = '';
        $pc = -1;
        $visited = [];
        while (true) {
            ++$pc;
            if (($pc < 0) or ($pc >= count($this->instructions))) {
                return false;
            }
            $a = explode(' ', $this->instructions[$pc]);
            switch ($a[0]) {
                case 'cpy':
                    if ((count($a) != 3) or !isset($registers[$a[2]])) {
                        throw new \Exception('Invalid instruction');
                    }
                    $registers[$a[2]] = $registers[$a[1]] ?? intval($a[1]);
                    break;
                case 'inc':
                    if ((count($a) != 2) or !isset($registers[$a[1]])) {
                        throw new \Exception('Invalid instruction');
                    }
                    ++$registers[$a[1]];
                    break;
                case 'dec':
                    if ((count($a) != 2) or !isset($registers[$a[1]])) {
                        throw new \Exception('Invalid instruction');
                    }
                    --$registers[$a[1]];
                    break;
                case 'jnz':
                    if (count($a) != 3) {
                        throw new \Exception('Invalid instruction');
                    }
                    if (($registers[$a[1]] ?? intval($a[1])) != 0) {
                        $pc += ($registers[$a[2]] ?? intval($a[2])) - 1;
                    }
                    break;
                case 'out':
                    if (count($a) != 2) {
                        throw new \Exception('Invalid instruction');
                    }
                    $value = $registers[$a[1]] ?? intval($a[1]);
                    if ($value != strlen($output) % 2) {
                        return false;
                    }
                    $output .= strval($value);
                    $hash = "{$pc} {$registers['a']} {$registers['b']} {$registers['c']} {$registers['d']} {$output}";
                    $visited[$hash] = true;
                    $prevOutput = $output;
                    while (strlen($prevOutput) >= 2) {
                        $prevOutput = substr($prevOutput, 0, -2);
                        $prevHash = "{$pc} {$registers['a']} {$registers['b']} {$registers['c']} {$registers['d']} "
                            . "{$prevOutput}";
                        if (isset($visited[$prevHash])) {
                            return true;
                        }
                    }
                    break;
                default:
                    throw new \Exception('Invalid instruction');
            }
        }
    }
}

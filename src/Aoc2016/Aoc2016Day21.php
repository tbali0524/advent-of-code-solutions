<?php

declare(strict_types=1);

namespace TBali\Aoc2016;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2016 Day 21: Scrambled Letters and Hash.
 *
 * Part 1: Given the list of scrambling operations in your puzzle input, what is the result of scrambling abcdefgh?
 * Part 2: What is the un-scrambled version of the scrambled password fbgdceah?
 *
 * @see https://adventofcode.com/2016/day/21
 */
final class Aoc2016Day21 extends SolutionBase
{
    public const YEAR = 2016;
    public const DAY = 21;
    public const TITLE = 'Scrambled Letters and Hash';
    public const SOLUTIONS = ['bfheacgd', 'gcehdbfa'];
    public const EXAMPLE_SOLUTIONS = [['decab', 0], [0, 0]];

    private const CLEARTEXT_EXAMPLE = 'abcde';
    private const CLEARTEXT_PART1 = 'abcdefgh';
    private const ENCRYPTED_TEXT_EXAMPLE = 'decab';
    private const ENCRYPTED_TEXT_PART2 = 'fbgdceah';

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
        // detect example input
        $clear = (count($input) == 8 ? self::CLEARTEXT_EXAMPLE : self::CLEARTEXT_PART1);
        $encrypt = (count($input) == 8 ? self::ENCRYPTED_TEXT_EXAMPLE : self::ENCRYPTED_TEXT_PART2);
        // ---------- Part 1
        $ans1 = $clear;
        foreach ($input as $line) {
            $ans1 = $this->execute($ans1, $line);
        }
        // ---------- Part 2
        $ans2 = $encrypt;
        for ($i = count($input) - 1; $i >= 0; --$i) {
            $ans2 = $this->execute($ans2, $input[$i], true);
        }
        echo '------------' . $ans2;
        return [$ans1, $ans2];
    }

    private function execute(string $s, string $instruction, bool $reverse = false): string
    {
        $a = explode(' ', $instruction);
        if (str_starts_with($instruction, 'swap position ')) {
            if ((count($a) != 6) or !str_contains($instruction, ' with position ')) {
                throw new \Exception('Invalid input');
            }
            $pos1 = intval($a[2]);
            $pos2 = intval($a[5]);
            if (($pos1 < 0) or ($pos1 >= strlen($s)) or ($pos2 < 0) or ($pos2 >= strlen($s))) {
                throw new \Exception('Invalid input');
            }
            $temp = $s[$pos1];
            $s[$pos1] = $s[$pos2];
            $s[$pos2] = $temp;
            return $s;
        }
        if (str_starts_with($instruction, 'swap letter ')) {
            if ((count($a) != 6) or !str_contains($instruction, ' with letter ')) {
                throw new \Exception('Invalid input');
            }
            $pos1 = strpos($s, $a[2]);
            $pos2 = strpos($s, $a[5]);
            if (($pos1 === false) or ($pos2 === false)) {
                throw new \Exception('Invalid input');
            }
            $temp = $s[$pos1];
            $s[$pos1] = $s[$pos2];
            $s[$pos2] = $temp;
            return $s;
        }
        if (str_starts_with($instruction, 'rotate left ')) {
            if ((count($a) != 4) or !str_contains($instruction, ' step')) {
                throw new \Exception('Invalid input');
            }
            $by = intval($a[2]) % strlen($s);
            if ($reverse) {
                $by *= -1;
            }
            return substr($s, $by) . substr($s, 0, $by);
        }
        if (str_starts_with($instruction, 'rotate right ')) {
            if ((count($a) != 4) or !str_contains($instruction, ' step')) {
                throw new \Exception('Invalid input');
            }
            $by = intval($a[2]) % strlen($s);
            if ($reverse) {
                $by *= -1;
            }
            return substr($s, -$by) . substr($s, 0, -$by);
        }
        if (str_starts_with($instruction, 'rotate based on position of letter ')) {
            if (count($a) != 7) {
                throw new \Exception('Invalid input');
            }
            $pos1 = strpos($s, $a[6]);
            if ($pos1 === false) {
                throw new \Exception('Invalid input');
            }
            /*
                from -> rotate by => to
                0 -> r 1 => p 1
                1 -> r 2 => p 3
                2 -> r 3 => p 5  mod 5 = 0, mod 8 = 5
                3 -> r 4 => p 7  mod 5 = 2, mod 8 = 7
                4 -> r 6 => p 10 mod 5 = 0, mod 8 = 2
                5 -> r 7 => p 12            mod 8 = 4
                6 -> r 8 => p 14            mod 8 = 6
                7 -> r 9 => p 16            mod 8 = 0
            */
            if ($reverse) {
                if (strlen($s) == 8) {
                    $pos2 = array_search($pos1, [1, 3, 5, 7, 2, 4, 6, 0], true);
                } elseif (strlen($s) == 5) {
                    $pos2 = array_search($pos1, [1, 3, 0, 2, 0], true);
                } else {
                    $pos2 = false;
                }
                if ($pos2 === false) {
                    throw new \Exception('Only strings of 5 or 8 lenggth supported');
                }
                $by = $pos2 - $pos1;
            } else {
                $by = ($pos1 >= 4 ? $pos1 + 2 : $pos1 + 1) % strlen($s);
                return substr($s, -$by) . substr($s, 0, -$by);
            }
            return substr($s, -$by) . substr($s, 0, -$by);
        }
        if (str_starts_with($instruction, 'reverse positions ')) {
            if ((count($a) != 5) or !str_contains($instruction, ' through ')) {
                throw new \Exception('Invalid input');
            }
            $pos1 = intval($a[2]);
            $pos2 = intval($a[4]);
            if (($pos1 < 0) or ($pos1 >= strlen($s)) or ($pos2 < 0) or ($pos2 >= strlen($s)) or ($pos2 < $pos1)) {
                throw new \Exception('Invalid input');
            }
            return substr($s, 0, $pos1) . strrev(substr($s, $pos1, $pos2 - $pos1 + 1)) . substr($s, $pos2 + 1);
        }
        if (str_starts_with($instruction, 'move position ')) {
            if ((count($a) != 6) or !str_contains($instruction, ' to position ')) {
                throw new \Exception('Invalid input');
            }
            $pos1 = intval($a[2]);
            $pos2 = intval($a[5]);
            if (($pos1 < 0) or ($pos1 >= strlen($s)) or ($pos2 < 0) or ($pos2 >= strlen($s))) {
                throw new \Exception('Invalid input');
            }
            if ($reverse) {
                [$pos1, $pos2] = [$pos2, $pos1];
            }
            $temp = $s[$pos1];
            $s = substr($s, 0, $pos1) . substr($s, $pos1 + 1);
            return substr($s, 0, $pos2) . $temp . substr($s, $pos2);
        }
        throw new \Exception('Invalid input');
    }
}

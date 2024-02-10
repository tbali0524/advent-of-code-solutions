<?php

declare(strict_types=1);

namespace TBali\Aoc2015;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2015 Day 11: Corporate Policy.
 *
 * Part 1: Given Santa's current password (your puzzle input), what should his next password be?
 * Part 2: Santa's password expired again. What's the next one?
 *
 * Topics: string validation
 *
 * @see https://adventofcode.com/2015/day/11
 */
final class Aoc2015Day11 extends SolutionBase
{
    public const YEAR = 2015;
    public const DAY = 11;
    public const TITLE = 'Corporate Policy';
    public const SOLUTIONS = ['vzbxxyzz', 'vzcaabcc'];
    public const STRING_INPUT = 'vzbxkghb';
    public const EXAMPLE_SOLUTIONS = [['abcdffaa', '0'], ['ghjaabcc', '0']];
    public const EXAMPLE_STRING_INPUTS = ['abcdefgh', 'ghijklmn'];

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
        $input = $input[0];
        // ---------- Part 1
        $ans1 = $this->getNextPassword($input);
        // ---------- Part 2
        $ans2 = $this->getNextPassword($ans1);
        return [strval($ans1), strval($ans2)];
    }

    private function getNextPassword(string $pw): string
    {
        while (true) {
            $i = strlen($pw) - 1;
            while (($i >= 0) and ($pw[$i] == 'z')) {
                $pw[$i] = 'a';
                --$i;
            }
            if ($i < 0) {
                // @codeCoverageIgnoreStart
                throw new \Exception('Password overflow');
                // @codeCoverageIgnoreEnd
            }
            $pw[$i] = chr(ord($pw[$i]) + 1);
            $isOk = false;
            for ($i = 2; $i < strlen($pw); ++$i) {
                if ((ord($pw[$i]) - ord($pw[$i - 1]) == 1) and (ord($pw[$i - 1]) - ord($pw[$i - 2]) == 1)) {
                    $isOk = true;
                    break;
                }
            }
            if (!$isOk) {
                // @codeCoverageIgnoreStart
                continue;
                // @codeCoverageIgnoreEnd
            }
            $count = 0;
            foreach (str_split('iol') as $needle) {
                $count += substr_count($pw, $needle);
            }
            if ($count > 0) {
                continue;
            }
            $firstPos = [];
            $count = 0;
            for ($i = 1; $i < strlen($pw); ++$i) {
                if ($pw[$i] != $pw[$i - 1]) {
                    continue;
                }
                if (isset($firstPos[$pw[$i]])) {
                    if ($i - $firstPos[$pw[$i]] == 1) {
                        continue;
                    }
                } else {
                    $firstPos[$pw[$i]] = $i;
                }
                ++$count;
            }
            if ($count >= 2) {
                break;
            }
        }
        return $pw;
    }
}

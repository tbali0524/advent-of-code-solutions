<?php

declare(strict_types=1);

namespace TBali\Aoc2016;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2016 Day 6: Signals and Noise.
 *
 * Part 1: What is the error-corrected version of the message being sent?
 * Part 2: Given this new decoding methodology, what is the original message that Santa is trying to send?
 *
 * @see https://adventofcode.com/2016/day/6
 */
final class Aoc2016Day06 extends SolutionBase
{
    public const YEAR = 2016;
    public const DAY = 6;
    public const TITLE = 'Signals and Noise';
    public const SOLUTIONS = ['cyxeoccr', 'batwpask'];
    public const EXAMPLE_SOLUTIONS = [['easter', 'advent'], [0, 0]];

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
        $ans1 = '';
        $ans2 = '';
        for ($i = 0; $i < strlen($input[0] ?? ''); ++$i) {
            $s = '';
            foreach ($input as $line) {
                $s .= $line[$i];
            }
            // mode = 1: return an array with the byte-value as key and the frequency of every byte as value,
            //           but only byte-values with a frequency greater than zero are listed.
            /** @var array<int, int> */
            $freq = count_chars($s, 1);
            arsort($freq);
            $ans1 .= chr(array_key_first($freq) ?? 0);
            $ans2 .= chr(array_key_last($freq) ?? 0);
        }
        return [$ans1, $ans2];
    }
}

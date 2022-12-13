<?php

declare(strict_types=1);

namespace TBali\Aoc2020;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2020 Day 25: Combo Breaker.
 *
 * Part 1: What encryption key is the handshake trying to establish?
 * Part 2: N/A
 *
 * Topics: asymmetric key encryption
 *
 * @see https://adventofcode.com/2020/day/25
 */
final class Aoc2020Day25 extends SolutionBase
{
    public const YEAR = 2020;
    public const DAY = 25;
    public const TITLE = 'Combo Breaker';
    public const SOLUTIONS = [11707042, 0];
    public const EXAMPLE_SOLUTIONS = [[14897079, 0]];

    private const SUBJECT_NUMBER = 7;
    private const MODULUS = 20201227;

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
        if (count($input) != 2) {
            throw new \Exception('Invalid input');
        }
        $cardPublicKey = intval($input[0]);
        $doorPublicKey = intval($input[1]);
        // ---------- Part 1 + 2
        $value = 1;
        $cardLoopSize = 0;
        while (true) {
            if ($value == $cardPublicKey) {
                break;
            }
            ++$cardLoopSize;
            $value = ($value * self::SUBJECT_NUMBER) % self::MODULUS;
        }
        $value = 1;
        for ($i = 0; $i < $cardLoopSize; ++$i) {
            $value = ($value * $doorPublicKey) % self::MODULUS;
        }
        $ans1 = $value;
        $ans2 = 0;
        return [strval($ans1), strval($ans2)];
    }
}

<?php

declare(strict_types=1);

namespace TBali\Aoc2022;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2022 Day 3: Rucksack Reorganization.
 *
 * Part 1: Find the item type that appears in both compartments of each rucksack.
 *         What is the sum of the priorities of those item types?
 * Part 2: Find the item type that corresponds to the badges of each three-Elf group.
 *         What is the sum of the priorities of those item types?
 *
 * @see https://adventofcode.com/2022/day/3
 */
final class Aoc2022Day03 extends SolutionBase
{
    public const YEAR = 2022;
    public const DAY = 3;
    public const TITLE = 'Rucksack Reorganization';
    public const SOLUTIONS = [7766, 2415];
    public const EXAMPLE_SOLUTIONS = [[157, 70]];

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
        $ans1 = 0;
        foreach ($input as $line) {
            $left = substr($line, 0, intdiv(strlen($line), 2));
            $right = substr($line, intdiv(strlen($line), 2));
            for ($i = 0; $i < strlen($right); ++$i) {
                if (str_contains($left, $right[$i])) {
                    $ans1 += $this->getPriority($right[$i]);
                    break;
                }
            }
        }
        // ---------- Part 2
        $ans2 = 0;
        $groupSize = 3;
        for ($group = 0; $group < count($input); $group += $groupSize) {
            $letters = ['a' => 0];
            for ($elf = 0; $elf < $groupSize; ++$elf) {
                for ($i = 0; $i < strlen($input[$group + $elf]); ++$i) {
                    $c = $input[$group + $elf][$i];
                    $letters[$c] = ($letters[$c] ?? 0) | (1 << $elf);
                }
            }
            arsort($letters);
            $c = array_key_first($letters);
            if ($letters[$c] != (1 << $groupSize) - 1) {
                // @codeCoverageIgnoreStart
                throw new \Exception('Invalid input');
                // @codeCoverageIgnoreEnd
            }
            $ans2 += $this->getPriority($c);
        }
        return [strval($ans1), strval($ans2)];
    }

    private function getPriority(string $s): int
    {
        return
            $s >= 'a' && $s <= 'z'
            ? ord($s) - ord('a') + 1
            : ord($s) - ord('A') + 27;
    }
}

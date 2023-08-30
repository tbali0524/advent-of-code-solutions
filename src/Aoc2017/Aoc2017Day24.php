<?php

declare(strict_types=1);

namespace TBali\Aoc2017;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2017 Day 24: Electromagnetic Moat.
 *
 * Part 1: What is the strength of the strongest bridge you can make with the components you have available?
 * Part 2: What is the strength of the longest bridge you can make?
 *
 * Topics: BFS
 *
 * @see https://adventofcode.com/2017/day/24
 */
final class Aoc2017Day24 extends SolutionBase
{
    public const YEAR = 2017;
    public const DAY = 24;
    public const TITLE = 'Electromagnetic Moat';
    public const SOLUTIONS = [1656, 1642];
    public const EXAMPLE_SOLUTIONS = [[31, 19]];

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
        $components = array_map(
            static fn (string $line): array => array_map(intval(...), explode('/', $line)),
            $input
        );
        if (count(array_filter($components, static fn (array $a): bool => count($a) != 2)) != 0) {
            throw new \Exception('Invalid input');
        }
        // ---------- Part 1 + 2
        $ans1 = 0;
        $maxPerLength = [];
        $visited = [];
        $q = [[0, 0, 0, 0]];
        $readIdx = 0;
        while ($readIdx < count($q)) {
            [$usedBitmap, $rightPort, $strength, $length] = $q[$readIdx];
            ++$readIdx;
            $maxPerLength[$length] = intval(max($strength, $maxPerLength[$length] ?? 0));
            foreach ($components as $idx => $component) {
                if (($usedBitmap & (1 << $idx)) != 0) {
                    continue;
                }
                for ($i = 0; $i < 2; ++$i) {
                    $left = $component[$i];
                    if ($left != $rightPort) {
                        continue;
                    }
                    $newBitMap = $usedBitmap | (1 << $idx);
                    $newRight = $component[1 - $i];
                    $newStrength = $strength + $left + $newRight;
                    $newLength = $length + 1;
                    $hash = $newBitMap . ' ' . $newRight . ' ' . $newStrength . ' ' . $newLength;
                    if (isset($visited[$hash])) {
                        continue;
                    }
                    $q[] = [$newBitMap, $newRight, $newStrength, $newLength];
                    $visited[$hash] = true;
                }
            }
        }
        $ans1 = max($maxPerLength);
        krsort($maxPerLength);
        $maxLength = array_key_first($maxPerLength);
        $ans2 = $maxPerLength[$maxLength];
        return [strval($ans1), strval($ans2)];
    }
}

<?php

declare(strict_types=1);

namespace TBali\Aoc2023;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2023 Day 4: Scratchcards.
 *
 * Part 1: Take a seat in the large pile of colorful cards. How many points are they worth in total?
 * Part 2: Including the original set of scratchcards, how many total scratchcards do you end up with?
 *
 * @see https://adventofcode.com/2023/day/4
 */
final class Aoc2023Day04 extends SolutionBase
{
    public const YEAR = 2023;
    public const DAY = 4;
    public const TITLE = 'Scratchcards';
    public const SOLUTIONS = [21088, 6874754];
    public const EXAMPLE_SOLUTIONS = [[13, 30]];

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
        $winNumbers = [];
        $haveNumbers = [];
        foreach ($input as $line) {
            $a = explode(': ', str_replace('  ', ' ', $line));
            if ((count($a) != 2) or !str_starts_with($line, 'Card ')) {
                throw new \Exception('Invalid input');
            }
            // $id = intval(substr($a[0], 5));
            $b = explode(' | ', $a[1]);
            if (count($b) != 2) {
                throw new \Exception('Invalid input');
            }
            $winNumbers[] = array_map(intval(...), explode(' ', $b[0]));
            $haveNumbers[] = array_map(intval(...), explode(' ', $b[1]));
        }
        // ---------- Part 1 + 2
        $ans1 = 0;
        $ans2 = 0;
        $countCards = array_fill(0, count($input), 1) ?: [];
        foreach ($haveNumbers as $idxCard => $haveList) {
            $countMatch = 0;
            foreach ($haveList as $number) {
                if (in_array($number, $winNumbers[$idxCard], true)) {
                    ++$countMatch;
                }
            }
            if ($countMatch > 0) {
                $ans1 += 1 << ($countMatch - 1);
                for ($i = $idxCard + 1; $i < min(count($input), $idxCard + 1 + $countMatch); ++$i) {
                    $countCards[$i] += $countCards[$idxCard];
                }
            }
        }
        $ans2 = array_sum($countCards);
        return [strval($ans1), strval($ans2)];
    }
}

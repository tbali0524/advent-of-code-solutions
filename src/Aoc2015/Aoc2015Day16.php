<?php

declare(strict_types=1);

namespace TBali\Aoc2015;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2015 Day 16: Aunt Sue.
 *
 * Part 1: What is the number of the Sue that got you the gift?
 * Part 2: What is the number of the real Aunt Sue?
 *
 * Topics: find matching object based on properties
 *
 * @see https://adventofcode.com/2015/day/16
 */
final class Aoc2015Day16 extends SolutionBase
{
    public const YEAR = 2015;
    public const DAY = 16;
    public const TITLE = 'Aunt Sue';
    public const SOLUTIONS = [373, 260];

    private const AUNT_SPEC = [
        'children' => 3,
        'cats' => 7,
        'samoyeds' => 2,
        'pomeranians' => 3,
        'akitas' => 0,
        'vizslas' => 0,
        'goldfish' => 5,
        'trees' => 3,
        'cars' => 2,
        'perfumes' => 1,
    ];
    private const EXPECTED_COMPARE_RESULT = [
        'children' => 0,
        'cats' => 1,
        'samoyeds' => 0,
        'pomeranians' => -1,
        'akitas' => 0,
        'vizslas' => 0,
        'goldfish' => -1,
        'trees' => 1,
        'cars' => 0,
        'perfumes' => 0,
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
        $aunts = $this->parseInput($input);
        // ---------- Part 1
        $ans1 = 0;
        foreach ($aunts as $id => $aunt) {
            $isOk = true;
            foreach ($aunt as $propName => $propValue) {
                if ((self::AUNT_SPEC[$propName] ?? -1) != $propValue) {
                    $isOk = false;
                    break;
                }
            }
            if ($isOk) {
                $ans1 = $id;
                break;
            }
        }
        // ---------- Part 2
        $ans2 = 0;
        foreach ($aunts as $id => $aunt) {
            $isOk = true;
            foreach ($aunt as $propName => $propValue) {
                if (!isset(self::AUNT_SPEC[$propName])) {
                    continue;
                }
                $comp = $propValue <=> self::AUNT_SPEC[$propName];
                if ($comp != self::EXPECTED_COMPARE_RESULT[$propName]) {
                    $isOk = false;
                    break;
                }
            }
            if ($isOk) {
                $ans2 = $id;
                break;
            }
        }
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param array<int, string> $input
     *
     * @return array<int, array<string, int>>
     */
    private function parseInput(array $input): array
    {
        $aunts = [];
        foreach ($input as $line) {
            $a = explode(' ', $line);
            if (count($a) != 8) {
                throw new \Exception('Invalid input');
            }
            $aunt = [];
            $id = intval(substr($a[1], 0, -1));
            for ($i = 0; $i < 3; ++$i) {
                $propName = substr($a[2 + 2 * $i], 0, -1);
                if ($i < 2) {
                    $propValue = intval(substr($a[3 + 2 * $i], 0, -1));
                } else {
                    $propValue = intval($a[7]);
                }
                $aunt[$propName] = $propValue;
            }
            $aunts[$id] = $aunt;
        }
        return $aunts;
    }
}

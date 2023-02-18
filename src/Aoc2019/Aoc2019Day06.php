<?php

declare(strict_types=1);

namespace TBali\Aoc2019;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2019 Day 6: Universal Orbit Map.
 *
 * Part 1: What is the total number of direct and indirect orbits in your map data?
 * Part 2: What is the minimum number of orbital transfers required to move from the object YOU are orbiting
 *         to the object SAN is orbiting?
 *
 * Topics: tree graph
 *
 * @see https://adventofcode.com/2019/day/6
 */
final class Aoc2019Day06 extends SolutionBase
{
    public const YEAR = 2019;
    public const DAY = 6;
    public const TITLE = 'Universal Orbit Map';
    public const SOLUTIONS = [247089, 442];
    public const EXAMPLE_SOLUTIONS = [[42, 0], [0, 4]];

    /** @var array<string, string> */
    private array $orbits;
    /** @var array<string, int> */
    private array $countOrbits;

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
        $this->orbits = [];
        foreach ($input as $line) {
            $a = explode(')', $line);
            if (count($a) != 2) {
                throw new \Exception('Invalid input');
            }
            $this->orbits['x' . $a[1]] = 'x' . $a[0]; // x added to avoid type error with planet 984 in input
        }
        // ---------- Part 1
        $this->countOrbits = [];
        $ans1 = 0;
        foreach ($this->orbits as $planet => $center) {
            $ans1 += $this->countOrbit($planet);
        }
        // ---------- Part 2
        $ans2 = 0;
        if (!isset($this->orbits['xYOU'])) {
            return [strval($ans1), strval($ans2)];
        }
        $visitedAt = [];
        $step = 0;
        $planet = 'xYOU';
        while (true) {
            if (!isset($this->orbits[$planet])) {
                break;
            }
            $planet = $this->orbits[$planet];
            $visitedAt[$planet] = $step;
            ++$step;
        }
        $step = 0;
        $planet = 'xSAN';
        while (true) {
            if (!isset($this->orbits[$planet])) {
                throw new \Exception('Invalid input');
            }
            $planet = $this->orbits[$planet];
            if (isset($visitedAt[$planet])) {
                $ans2 = $visitedAt[$planet] + $step;
                break;
            }
            ++$step;
        }
        return [strval($ans1), strval($ans2)];
    }

    private function countOrbit(string $planet): int
    {
        if (isset($this->countOrbits[$planet])) {
            return $this->countOrbits[$planet];
        }
        if (!isset($this->orbits[$planet])) {
            return 0;
        }
        $this->countOrbits[$planet] = $this->countOrbit($this->orbits[$planet]) + 1;
        return $this->countOrbits[$planet];
    }
}

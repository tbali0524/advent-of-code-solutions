<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2022;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2022 Day 15: Beacon Exclusion Zone.
 *
 * Part 1: In the row where y=2000000, how many positions cannot contain a beacon?
 * Part 2: Find the only possible position for the distress beacon. What is its tuning frequency?
 *
 * @see https://adventofcode.com/2022/day/15
 *
 * @todo Part2
 */
final class Aoc2022Day15 extends SolutionBase
{
    public const YEAR = 2022;
    public const DAY = 15;
    public const TITLE = 'Beacon Exclusion Zone';
    public const SOLUTIONS = [5142231, 0];
    public const EXAMPLE_SOLUTIONS = [[26, 56000011]];

    private const TARGET_Y_EXAMPLE = 10;
    private const TARGET_Y_PART1 = 2_000_000;
    private const MAX_COORD_EXAMPLE = 20;
    private const MAX_COORD_PART2 = 4_000_000;

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
        $targetY = (count($input) == 14 ? self::TARGET_Y_EXAMPLE : self::TARGET_Y_PART1);
        $maxCoord = (count($input) == 14 ? self::MAX_COORD_EXAMPLE : self::MAX_COORD_PART2);
        $sensors = [];
        foreach ($input as $line) {
            $sensors[] = Sensor::fromString($line);
        }
        // ---------- Part 1
        $invalids = [];
        foreach ($sensors as $sensor) {
            if (abs($sensor->y - $targetY) > $sensor->distance) {
                continue;
            }
            for ($x = $sensor->x - $sensor->distance; $x <= $sensor->x + $sensor->distance; ++$x) {
                $dist = abs($sensor->x - $x) + abs($sensor->y - $targetY);
                if ($dist > $sensor->distance) {
                    continue;
                }
                if (($dist == $sensor->distance) and ($x == $sensor->beaconX) and ($targetY == $sensor->beaconY)) {
                    continue;
                }
                $invalids[$x] = true;
            }
        }
        $ans1 = count($invalids);
        // ---------- Part 2
        $ans2 = 0;
        return [strval($ans1), strval($ans2)];
    }
}

// --------------------------------------------------------------------
final class Sensor
{
    public int $x;
    public int $y;
    public int $beaconX;
    public int $beaconY;
    public int $distance;

    public static function fromString(string $s): self
    {
        if (
            !str_starts_with($s, 'Sensor at ')
            or !str_contains($s, ': closest beacon is at x=')
        ) {
            throw new \Exception('Invalid input');
        }
        $a = explode(': closest beacon is at x=', substr($s, 12));
        $b = explode(', y=', $a[0]);
        $c = explode(', y=', $a[1] ?? '');
        if ((count($a) != 2) or (count($b) != 2) or (count($c) != 2)) {
            throw new \Exception('Invalid input');
        }
        $sensor = new self();
        $sensor->x = intval($b[0]);
        $sensor->y = intval($b[1]);
        $sensor->beaconX = intval($c[0]);
        $sensor->beaconY = intval($c[1]);
        $sensor->distance = abs($sensor->x - $sensor->beaconX) + abs($sensor->y - $sensor->beaconY);
        return $sensor;
    }
}

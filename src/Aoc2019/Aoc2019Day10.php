<?php

declare(strict_types=1);

namespace TBali\Aoc2019;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2019 Day 10: Monitoring Station.
 *
 * Part 1: How many other asteroids can be detected from that location?
 * Part 2: The Elves are placing bets on which will be the 200th asteroid to be vaporized.
 *         What do you get if you multiply its X coordinate by 100 and then add its Y coordinate?
 *
 * @see https://adventofcode.com/2019/day/10
 */
final class Aoc2019Day10 extends SolutionBase
{
    public const YEAR = 2019;
    public const DAY = 10;
    public const TITLE = 'Monitoring Station';
    public const SOLUTIONS = [292, 317];
    public const EXAMPLE_SOLUTIONS = [[8, 0], [33, 0], [35, 0], [41, 0], [210, 802], [0, 1303]];

    private const ASTEROID_COUNT_PART2 = 200;

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
        $maxY = count($input);
        $maxX = strlen($input[0]);
        $ans1 = 0;
        $stationX = 0;
        $stationY = 0;
        $hasX = false;
        for ($y = 0; $y < $maxY; ++$y) {
            for ($x = 0; $x < $maxX; ++$x) {
                if ($input[$y][$x] == 'X') {
                    $hasX = true;
                    $ans1 = 0;
                    $stationX = $x;
                    $stationY = $y;
                    break 2;
                }
                if ($input[$y][$x] != '#') {
                    continue;
                }
                $count = 0;
                for ($astY = 0; $astY < $maxY; ++$astY) {
                    for ($astX = 0; $astX < $maxX; ++$astX) {
                        if ($input[$astY][$astX] != '#') {
                            continue;
                        }
                        if (($x == $astX) and ($y == $astY)) {
                            continue;
                        }
                        $dx = $astX <=> $x;
                        $dy = $astY <=> $y;
                        $isOk = true;
                        if ($dy == 0) {
                            $spaceY = $y;
                            for ($spaceX = $x + $dx; $spaceX != $astX; $spaceX += $dx) {
                                if ($input[$spaceY][$spaceX] == '#') {
                                    $isOk = false;
                                    break;
                                }
                            }
                        } else {
                            $maxStep = abs($astY - $y);
                            $steepness = abs($astX - $x) / $maxStep;
                            for ($step = 1; $step < $maxStep; ++$step) {
                                $spaceY = $y + $step * $dy;
                                $spaceX = $x + $step * $steepness * $dx;
                                if (abs($spaceX - round($spaceX)) > 0.0001) {
                                    continue;
                                }
                                $spaceX = intval(round($spaceX));
                                if ($input[$spaceY][$spaceX] == '#') {
                                    $isOk = false;
                                    break;
                                }
                            }
                        }
                        if (!$isOk) {
                            continue;
                        }
                        ++$count;
                    }
                }
                if ($count > $ans1) {
                    $ans1 = $count;
                    $stationX = $x;
                    $stationY = $y;
                }
            }
        }
        // ---------- Part 2
        $ans2 = 0;
        $x = $stationX;
        $y = $stationY;
        $asteroids = [];
        $directions = [];
        for ($astY = 0; $astY < $maxY; ++$astY) {
            for ($astX = 0; $astX < $maxX; ++$astX) {
                if ($input[$astY][$astX] != '#') {
                    continue;
                }
                if (($x == $astX) and ($y == $astY)) {
                    continue;
                }
                $direction = M_PI_2 - atan2($y - $astY, $astX - $x);
                if ($direction < 0) {
                    $direction += 2 * M_PI;
                }
                $dist2 = ($astX - $x) ** 2 + ($astY - $y) ** 2;
                $asteroids[] = [$direction, $dist2, $astX, $astY];
                if (!in_array($direction, $directions, true)) {
                    $directions[] = $direction;
                }
            }
        }
        $maxAsteroid = count($asteroids);
        usort($asteroids, function (array $a, array $b): int {
            $result = $a[0] <=> $b[0];
            return $result != 0 ? $result : $a[1] <=> $b[1];
        });
        sort($directions);
        $countShot = 0;
        $idxDirection = -1;
        while (true) {
            $idxDirection = ($idxDirection + 1) % count($directions);
            $filtered = array_filter($asteroids, fn (array $a): bool => $a[0] == $directions[$idxDirection]);
            if (count($filtered) == 0) {
                continue;
            }
            $key = array_key_first($filtered);
            ++$countShot;
            if ($countShot == self::ASTEROID_COUNT_PART2) {
                [$direction, $dist2, $astX, $astY] = $asteroids[$key];
                $ans2 = $astX * 100 + $astY;
                break;
            }
            if ($countShot == $maxAsteroid - 1) {
                if ($hasX) {
                    [$direction, $dist2, $astX, $astY] = $asteroids[$key];
                    $ans2 = $astX * 100 + $astY;
                }
                break;
            }
            unset($asteroids[$key]);
        }
        return [strval($ans1), strval($ans2)];
    }
}

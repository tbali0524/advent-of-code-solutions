<?php

declare(strict_types=1);

namespace TBali\Aoc2022;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2022 Day 18: Boiling Boulders.
 *
 * Part 1: What is the surface area of your scanned lava droplet?
 * Part 2: What is the exterior surface area of your scanned lava droplet?
 *
 * @see https://adventofcode.com/2022/day/18
 */
final class Aoc2022Day18 extends SolutionBase
{
    public const YEAR = 2022;
    public const DAY = 18;
    public const TITLE = 'Boiling Boulders';
    public const SOLUTIONS = [3498, 2008];
    public const EXAMPLE_SOLUTIONS = [[10, 10], [64, 58]];

    private const DELTAS = [[1, 0, 0], [-1, 0, 0], [0, 1, 0], [0, -1, 0], [0, 0, 1], [0, 0, -1]];

    /** @var array<int, int> */
    private array $minCoords = [];
    /** @var array<int, int> */
    private array $maxCoords = [];
    /** @var array<int, array<int, array<int, bool>>> */
    private array $grid = [];
    /** @var array<int, array<int, array<int, bool>>> */
    private array $external = [];

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
        $cubes = array_map(
            fn (string $s): array => array_map('intval', explode(',', $s)),
            $input
        );
        $this->grid = [];
        foreach ($cubes as $cube) {
            if (count($cube) != 3) {
                throw new \Exception('Invalid input');
            }
            [$x, $y, $z] = $cube;
            $this->grid[$z][$y][$x] = true;
        }
        // ---------- Part 1
        $ans1 = 0;
        foreach ($cubes as [$x, $y, $z]) {
            foreach (self::DELTAS as [$dx, $dy, $dz]) {
                if (!isset($this->grid[$z + $dz][$y + $dy][$x + $dx])) {
                    ++$ans1;
                }
            }
        }
        // ---------- Part 2
        $this->minCoords = [];
        $this->maxCoords = [];
        for ($i = 0; $i < 3; ++$i) {
            $coords = array_map(
                fn (array $a): int => $a[$i],
                $cubes
            );
            $this->minCoords[$i] = intval(min($coords));
            $this->maxCoords[$i] = intval(max($coords));
        }
        $this->external = [];
        $this->floodFill($this->minCoords[0] - 1, $this->minCoords[1] - 1, $this->minCoords[2] - 1);
        $ans2 = 0;
        foreach ($cubes as [$x, $y, $z]) {
            foreach (self::DELTAS as [$dx, $dy, $dz]) {
                if (isset($this->external[$z + $dz][$y + $dy][$x + $dx])) {
                    ++$ans2;
                }
            }
        }
        return [strval($ans1), strval($ans2)];
    }

    private function floodFill(int $x, int $y, int $z): void
    {
        if (
            ($x < $this->minCoords[0] - 1) or ($x > $this->maxCoords[0] + 1)
            or ($y < $this->minCoords[1] - 1) or ($y > $this->maxCoords[1] + 1)
            or ($z < $this->minCoords[2] - 1) or ($z > $this->maxCoords[2] + 1)
        ) {
            return;
        }
        if (isset($this->grid[$z][$y][$x])) {
            return;
        }
        if (isset($this->external[$z][$y][$x])) {
            return;
        }
        $this->external[$z][$y][$x] = true;
        foreach (self::DELTAS as [$dx, $dy, $dz]) {
            $this->floodFill($x + $dx, $y + $dy, $z + $dz);
        }
    }
}

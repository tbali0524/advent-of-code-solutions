<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2023;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2023 Day 22: Sand Slabs.
 *
 * Part 1: How many bricks could be safely chosen as the one to get disintegrated?
 * Part 2: What is the sum of the number of other bricks that would fall?
 *
 * Topics: simulation
 *
 * @see https://adventofcode.com/2023/day/22
 */
final class Aoc2023Day22 extends SolutionBase
{
    public const YEAR = 2023;
    public const DAY = 22;
    public const TITLE = 'Sand Slabs';
    public const SOLUTIONS = [434, 61209];
    public const EXAMPLE_SOLUTIONS = [[5, 7]];

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
        $bricks = [];
        foreach ($input as $id => $line) {
            $bricks[$id] = Brick::fromString($line, $id);
        }
        // ---------- Part 1 + 2
        $area = new Area($bricks);
        $area->freeFall();
        $area->calculateSupports();
        $ans1 = $area->countDisintegratable();
        $ans2 = $area->calculateChainDestructions();
        return [strval($ans1), strval($ans2)];
    }
}

// --------------------------------------------------------------------
final class Brick
{
    public int $id;
    /** @phpstan-var array{int, int, int} */
    public array $from = [0, 0, 0];
    /** @phpstan-var array{int, int, int} */
    public array $to = [0, 0, 0];

    public function __construct(int $id = 0)
    {
        $this->id = $id;
    }

    public static function fromString(string $s, int $id = 0): self
    {
        $count = sscanf($s, '%d,%d,%d~%d,%d,%d', $x1, $y1, $z1, $x2, $y2, $z2);
        if ($count != 6) {
            throw new \Exception('Invalid input');
        }
        $b = new self($id);
        $b->from = [intval($x1), intval($y1), intval($z1)];
        $b->to = [intval($x2), intval($y2), intval($z2)];
        if (
            ($b->from[0] < 0) or ($b->to[0] < $b->from[0])
            or ($b->from[1] < 0) or ($b->to[1] < $b->from[1])
            or ($b->from[2] < 0) or ($b->to[2] < $b->from[2])
            or ($b->from[2] == 0)
        ) {
            throw new \Exception('Invalid input');
        }
        return $b;
    }
}

// --------------------------------------------------------------------
final class Area
{
    private const EMPTY = -1;

    public int $maxX = 0;
    public int $maxY = 0;
    public int $maxZ = 0;
    /** @var array<int, Brick> */
    public array $bricks = [];
    /** @var array<int, array<int, array<int, int>>> */
    public array $grid = [];
    /** @var array<int, array<int, bool>> */
    public array $supporting = [];
    /** @var array<int, array<int, bool>> */
    public array $supportedBy = [];

    /**
     * @param array<int, Brick> $bricks the initial bricks (will be cloned to allow falling calculations later)
     */
    public function __construct(array $bricks)
    {
        $this->bricks = array_map(
            static fn (Brick $b): Brick => clone $b,
            $bricks,
        );
        $a = array_map(
            static fn (Brick $b): int => $b->to[0],
            $this->bricks,
        );
        $this->maxX = count($a) > 0 ? intval(max($a)) : 0;
        $a = array_map(
            static fn (Brick $b): int => $b->to[1],
            $this->bricks,
        );
        $this->maxY = count($a) > 0 ? intval(max($a)) : 0;
        $a = array_map(
            static fn (Brick $b): int => $b->to[2],
            $this->bricks,
        );
        $this->maxZ = count($a) > 0 ? intval(max($a)) : 0;
        $this->supporting = array_fill(0, count($this->bricks), []) ?: [];
        $this->supportedBy = array_fill(0, count($this->bricks), []) ?: [];
        $this->grid = array_fill(
            0,
            $this->maxX + 1,
            array_fill(
                0,
                $this->maxY + 1,
                array_fill(0, $this->maxZ + 2, self::EMPTY) ?: [], // extra layer added above to easy boundary check
            ) ?: [],
        ) ?: [];
        foreach ($this->bricks as $id => $b) {
            for ($x = $b->from[0]; $x <= $b->to[0]; ++$x) {
                for ($y = $b->from[1]; $y <= $b->to[1]; ++$y) {
                    for ($z = $b->from[2]; $z <= $b->to[2]; ++$z) {
                        if ($this->grid[$x][$y][$z] != self::EMPTY) {
                            throw new \Exception('Invalid input');
                        }
                        $this->grid[$x][$y][$z] = $id;
                    }
                }
            }
        }
    }

    public function freeFall(): void
    {
        $sortedBricks = $this->bricks;
        usort(
            $sortedBricks,
            static fn (Brick $a, Brick $b) => $a->from[2] <=> $b->from[2],
        );
        foreach ($sortedBricks as $b) {
            $newZ = 0;
            for ($z = $b->from[2] - 1; $z >= 0; --$z) {
                for ($x = $b->from[0]; $x <= $b->to[0]; ++$x) {
                    for ($y = $b->from[1]; $y <= $b->to[1]; ++$y) {
                        if ($this->grid[$x][$y][$z] != self::EMPTY) {
                            $newZ = $z + 1;
                            break 3;
                        }
                    }
                }
            }
            if ($newZ != $b->from[2]) {
                $this->fallBrickToZ($b->id, $newZ);
            }
        }
    }

    public function fallBrickToZ(int $id, int $newZ): void
    {
        $b = $this->bricks[$id];
        $fallBy = $b->from[2] - $newZ;
        for ($x = $b->from[0]; $x <= $b->to[0]; ++$x) {
            for ($y = $b->from[1]; $y <= $b->to[1]; ++$y) {
                for ($z = $b->from[2]; $z <= $b->to[2]; ++$z) {
                    $this->grid[$x][$y][$z] = self::EMPTY;
                }
                for ($z = $b->from[2] - $fallBy; $z <= $b->to[2] - $fallBy; ++$z) {
                    $this->grid[$x][$y][$z] = $b->id;
                }
            }
        }
        $b->from[2] -= $fallBy;
        $b->to[2] -= $fallBy;
    }

    public function calculateSupports(): void
    {
        $this->supporting = array_fill(0, count($this->bricks), []) ?: [];
        $this->supportedBy = array_fill(0, count($this->bricks), []) ?: [];
        foreach ($this->bricks as $id => $b) {
            for ($x = $b->from[0]; $x <= $b->to[0]; ++$x) {
                for ($y = $b->from[1]; $y <= $b->to[1]; ++$y) {
                    $idAbove = $this->grid[$x][$y][$b->to[2] + 1] ?? self::EMPTY;
                    if ($idAbove != self::EMPTY) {
                        $this->supporting[$id][$idAbove] = true;
                        $this->supportedBy[$idAbove][$id] = true;
                    }
                }
            }
        }
    }

    public function countDisintegratable(): int
    {
        $ans = 0;
        for ($i = 0; $i < count($this->bricks); ++$i) {
            $isOk = true;
            foreach (array_keys($this->supporting[$i]) as $idAbove) {
                if (count($this->supportedBy[$idAbove]) == 1) {
                    $isOk = false;
                    break;
                }
            }
            if ($isOk) {
                ++$ans;
            }
        }
        return $ans;
    }

    public function calculateChainDestructions(): int
    {
        $ans = 0;
        for ($i = 0; $i < count($this->bricks); ++$i) {
            $supportedBy = $this->supportedBy;
            $supporting = $this->supporting;
            $q = [$i];
            $readIdx = 0;
            while ($readIdx < count($q)) {
                $id = $q[$readIdx];
                ++$readIdx;
                foreach (array_keys($supporting[$id]) as $idAbove) {
                    unset($supportedBy[$idAbove][$id]);
                    if (count($supportedBy[$idAbove]) == 0) {
                        $q[] = $idAbove;
                    }
                }
            }
            $ans += $readIdx - 1;
        }
        return $ans;
    }
}

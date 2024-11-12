<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2021;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2021 Day 19: Beacon Scanner.
 *
 * Part 1: Assemble the full map of beacons. How many beacons are there?
 * Part 2: What is the largest Manhattan distance between any two scanners?
 *
 * Topics: vector, matrix, rotations
 *
 * @see https://adventofcode.com/2021/day/19
 */
final class Aoc2021Day19 extends SolutionBase
{
    public const YEAR = 2021;
    public const DAY = 19;
    public const TITLE = 'Beacon Scanner';
    public const SOLUTIONS = [308, 12124];
    public const EXAMPLE_SOLUTIONS = [[79, 3621]];

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
        $scanners = [];
        /** @var array<array<int, Vector3D>> $scanners */
        $maxScanners = 0;
        foreach ($input as $line) {
            if ($line == '') {
                continue;
            }
            if (str_starts_with($line, '--- scanner ')) {
                $scanners[$maxScanners] = [];
                ++$maxScanners;
                continue;
            }
            $p = array_map(intval(...), explode(',', $line));
            if (count($p) != 3) {
                throw new \Exception('Invalid input');
            }
            $scanners[$maxScanners - 1][] = new Vector3D($p);
        }
        if ($maxScanners == 0) {
            throw new \Exception('Invalid input');
        }
        // ---------- Part 1
        $ans1 = 0;
        $rotMatrices = new Rotations();
        $rotScanners = [];
        foreach ($scanners as $idScanner => $scanner) {
            foreach ($rotMatrices->r as $idRot => $rotMatrix) {
                $rotScanners[$idScanner][$idRot] = [];
                foreach ($scanner as $beacon) {
                    $rotScanners[$idScanner][$idRot][] = $beacon->multiplyByMatrix($rotMatrix);
                }
            }
        }
        $trueBeacons = [];
        $foundScanner = [];
        $scannerPositions = [];
        $scannerRotations = [];
        $foundScanner[0] = true;
        $scannerPositions[0] = new Vector3D([0, 0, 0]);
        $scannerRotations[0] = 0; // because of this, Rotation->r must contain the identity matrix as first element!
        foreach ($scanners[0] as $beacon) {
            $trueBeacons[] = $beacon;
            $alreadySeen[$beacon->toHash()] = true;
        }
        while (count($foundScanner) != $maxScanners) {
            for ($id1 = 0; $id1 < $maxScanners; ++$id1) {
                if (!isset($foundScanner[$id1])) {
                    continue;
                }
                $scanner1 = $rotScanners[$id1][$scannerRotations[$id1]];
                for ($id2 = 0; $id2 < $maxScanners; ++$id2) {
                    if (isset($foundScanner[$id2])) {
                        continue;
                    }
                    if ($id1 == $id2) {
                        continue;
                    }
                    for ($idRot = 0; $idRot < count($rotMatrices->r); ++$idRot) {
                        $countDeltas = [];
                        foreach ($scanner1 as $beacon1) {
                            foreach ($rotScanners[$id2][$idRot] as $beacon2) {
                                $hash = $beacon1->subtract($beacon2)->toHash();
                                $countDeltas[$hash] = ($countDeltas[$hash] ?? 0) + 1;
                            }
                        }
                        if (count($countDeltas) == 0) {
                            continue;
                        }
                        arsort($countDeltas);
                        $maxHash = intval(array_key_first($countDeltas));
                        $maxCount = $countDeltas[$maxHash];
                        if ($maxCount < 12) {
                            continue;
                        }
                        $delta = Vector3D::fromHash($maxHash)->add($scannerPositions[$id1]);
                        $foundScanner[$id2] = true;
                        $scannerPositions[$id2] = $delta;
                        $scannerRotations[$id2] = $idRot;
                        foreach ($rotScanners[$id2][$idRot] as $beacon2) {
                            $hash2 = $beacon2->add($delta)->toHash();
                            if (!isset($alreadySeen[$hash2])) {
                                $alreadySeen[$hash2] = true;
                                $trueBeacons[] = $beacon2->add($delta);
                            }
                        }
                        break;
                    }
                }
            }
        }
        $ans1 = count($trueBeacons);
        // ---------- Part 2
        $ans2 = 0;
        foreach ($scannerPositions as $id1 => $scanner1) {
            foreach ($scannerPositions as $id2 => $scanner2) {
                if ($id1 == $id2) {
                    continue;
                }
                $distance = $scanner1->manhattan($scanner2);
                if ($distance > $ans2) {
                    $ans2 = $distance;
                }
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}

// --------------------------------------------------------------------
// Utility class for a 3d vector of integer values with a limited value range.
final class Vector3D
{
    /** @phpstan-var array{int, int, int} */
    public const ZERO = [0, 0, 0];
    public const MAX = 10_000;
    public const MAXD = 2 * self::MAX;
    public const MAXS = self::MAXD ** 2;

    public function __construct(
        /** @phpstan-var array{int, int, int} */
        public array $p = self::ZERO,
    ) {
    }

    /**
     * @codeCoverageIgnore
     */
    public function toString(): string
    {
        return '[' . implode(',', $this->p) . ']';
    }

    public function toHash(): int
    {
        return ($this->p[0] + self::MAX) * self::MAXS
            + ($this->p[1] + self::MAX) * self::MAXD
            + ($this->p[2] + self::MAX);
    }

    public function add(self $b): self
    {
        return new self([$this->p[0] + $b->p[0], $this->p[1] + $b->p[1], $this->p[2] + $b->p[2]]);
    }

    public function subtract(self $b): self
    {
        return new self([$this->p[0] - $b->p[0], $this->p[1] - $b->p[1], $this->p[2] - $b->p[2]]);
    }

    /**
     * @codeCoverageIgnore
     */
    public function multiplyByScalar(int $b): self
    {
        $p = array_map(
            static fn (int $x): int => $x * $b,
            $this->p,
        );
        return new self($p);
    }

    public function multiplyByMatrix(Matrix $b): self
    {
        $p = self::ZERO;
        for ($j = 0; $j < 3; ++$j) {
            for ($k = 0; $k < 3; ++$k) {
                $p[$j] += $this->p[$k] * $b->m[$k][$j];
            }
        }
        return new self($p);
    }

    public function manhattan(self $b): int
    {
        return abs($this->p[0] - $b->p[0]) + abs($this->p[1] - $b->p[1]) + abs($this->p[2] - $b->p[2]);
    }

    public static function fromHash(int $hash): self
    {
        $z = $hash % self::MAXD - self::MAX;
        $y = intdiv($hash, self::MAXD) % self::MAXD - self::MAX;
        $x = intdiv($hash, self::MAXS) - self::MAX;
        return new self([$x, $y, $z]);
    }

    /**
     * @phpstan-param array{int, int, int} $p
     */
    public static function arrayToHash(array $p): int
    {
        return ($p[0] + self::MAX) * self::MAXS
            + ($p[1] + self::MAX) * self::MAXD
            + ($p[2] + self::MAX);
    }
}

// --------------------------------------------------------------------
// Utility class for 3x3 square matrix.
final class Matrix
{
    /** @phpstan-var array{array{int, int, int}, array{int, int, int}, array{int, int, int}} */
    public const ZERO = [
        [0, 0, 0],
        [0, 0, 0],
        [0, 0, 0],
    ];
    /** @phpstan-var array{array{int, int, int}, array{int, int, int}, array{int, int, int}} */
    public const IDENTITY = [
        [1, 0, 0],
        [0, 1, 0],
        [0, 0, 1],
    ];

    public function __construct(
        /** @phpstan-var array{array{int, int, int}, array{int, int, int}, array{int, int, int}} */
        public array $m = self::ZERO,
    ) {
    }

    /**
     * @codeCoverageIgnore
     */
    public function toString(): string
    {
        return implode('', array_map(
            static fn (array $row): string => '[' . implode(',', $row) . '],' . PHP_EOL,
            $this->m
        ));
    }

    /**
     * @codeCoverageIgnore
     */
    public function transpose(): self
    {
        // https://en.wikipedia.org/wiki/Transpose
        $m = self::ZERO;
        for ($i = 0; $i < 3; ++$i) {
            for ($j = 0; $j < 3; ++$j) {
                $m[$i][$j] = $this->m[$j][$i];
            }
        }
        return new self($m);
    }

    /**
     * @codeCoverageIgnore
     */
    public function multiply(self $b): self
    {
        // https://en.wikipedia.org/wiki/Matrix_multiplication
        $m = self::ZERO;
        for ($i = 0; $i < 3; ++$i) {
            for ($j = 0; $j < 3; ++$j) {
                for ($k = 0; $k < 3; ++$k) {
                    $m[$i][$j] += $this->m[$i][$k] * $b->m[$k][$j];
                }
            }
        }
        return new self($m);
    }

    /**
     * @phpstan-param array{Vector3D, Vector3D, Vector3D} $v
     *
     * @codeCoverageIgnore
     */
    public static function fromVectors(array $v): self
    {
        return new self([$v[0]->p, $v[1]->p, $v[2]->p]);
    }

    /**
     * @param array<int, Matrix> $matrices
     */
    public static function chainMultiply(array $matrices): self
    {
        if (count($matrices) < 2) {
            // @codeCoverageIgnoreStart
            throw new \Exception('Impossible');
            // @codeCoverageIgnoreEnd
        }
        $a = $matrices[0]->m;
        for ($idx = 1; $idx < count($matrices); ++$idx) {
            $m = self::ZERO;
            for ($i = 0; $i < 3; ++$i) {
                for ($j = 0; $j < 3; ++$j) {
                    for ($k = 0; $k < 3; ++$k) {
                        $m[$i][$j] += $a[$i][$k] * $matrices[$idx]->m[$k][$j];
                    }
                }
            }
            $a = $m;
        }
        return new self($m);
    }
}

// --------------------------------------------------------------------
// Singleton utility class to generate the 24 possible rotation matrices.
final class Rotations
{
    public const SINGLE_AXIS_ROTATIONS = [
        [
            // 4 rotations about x-axis, MUST begin with the identity matrix
            [
                [1, 0, 0],
                [0, 1, 0],
                [0, 0, 1],
            ],
            [
                [1, 0, 0],
                [0, 0, -1],
                [0, 1, 0],
            ],
            [
                [1, 0, 0],
                [0, -1, 0],
                [0, 0, -1],
            ],
            [
                [1, 0, 0],
                [0, 0, 1],
                [0, -1, 0],
            ],
        ],
        [
            // 4 rotations about y-axis
            [
                [1, 0, 0],
                [0, 1, 0],
                [0, 0, 1],
            ],
            [
                [0, 0, -1],
                [0, 1, 0],
                [1, 0, 0],
            ],
            [
                [-1, 0, 0],
                [0, 1, 0],
                [0, 0, -1],
            ],
            [
                [0, 0, 1],
                [0, 1, 0],
                [-1, 0, 0],
            ],
        ],
        [
            // 4 rotations about z-axis
            [
                [1, 0, 0],
                [0, 1, 0],
                [0, 0, 1],
            ],
            [
                [0, -1, 0],
                [1, 0, 0],
                [0, 0, 1],
            ],
            [
                [-1, 0, 0],
                [0, -1, 0],
                [0, 0, 1]],
            [
                [0, 1, 0],
                [-1, 0, 0],
                [0, 0, 1],
            ],
        ],
    ];
    /**
     * The 24 rotation matrices.
     *
     * @var array<int, Matrix>
     */
    public array $r;

    public function __construct()
    {
        $this->r = [];
        $singles = [];
        for ($axis = 0; $axis < 3; ++$axis) {
            for ($angle = 0; $angle < 4; ++$angle) {
                $singles[$axis][$angle] = new Matrix(self::SINGLE_AXIS_ROTATIONS[$axis][$angle]);
            }
        }
        $alreadySeen = [];
        for ($i = 0; $i < 4; ++$i) {
            $rotX = $singles[0][$i];
            for ($j = 0; $j < 4; ++$j) {
                $rotY = $singles[1][$j];
                for ($k = 0; $k < 4; ++$k) {
                    $rotZ = $singles[2][$k];
                    $product = Matrix::chainMultiply([$rotX, $rotY, $rotZ]);
                    $hash1 = Vector3D::arrayToHash($product->m[0]);
                    $hash2 = Vector3D::arrayToHash($product->m[1]);
                    $hash3 = Vector3D::arrayToHash($product->m[2]);
                    $hash = $hash1 . ' ' . $hash2 . ' ' . $hash3;
                    if (isset($alreadySeen[$hash])) {
                        continue;
                    }
                    $alreadySeen[$hash] = true;
                    $this->r[] = $product;
                }
            }
        }
    }
}

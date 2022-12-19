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
 */
final class Aoc2022Day15 extends SolutionBase
{
    public const YEAR = 2022;
    public const DAY = 15;
    public const TITLE = 'Beacon Exclusion Zone';
    public const SOLUTIONS = [5142231, 10884459367718];
    public const EXAMPLE_SOLUTIONS = [[26, 56000011]];

    private const DEBUG = false;
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
        $half = intdiv($maxCoord, 2);
        $bigRect = Rect::fromXY(-$half, $half, $maxCoord + $half, $half);
        $possibles = [$bigRect];
        // @phpstan-ignore-next-line
        if (self::DEBUG) {
            // @codeCoverageIgnoreStart
            echo 'BigRect: ' . $bigRect->toString(), PHP_EOL;
            // @codeCoverageIgnoreEnd
        }
        foreach ($sensors as $idxSensor => $sensor) {
            $invalidRect = Rect::fromSensor($sensor);
            $newPossibles = [];
            foreach ($possibles as $possible) {
                $newPossibles = array_merge($newPossibles, $possible->diff($invalidRect));
            }
            $possibles = $newPossibles;
            // @phpstan-ignore-next-line
            if (self::DEBUG and ($maxCoord == self::MAX_COORD_EXAMPLE)) {
                // @codeCoverageIgnoreStart
                echo '---- Removing locations based on sensor #' . $idxSensor . ': ' . $sensor->toString()
                    . ' = Rect ' . $invalidRect->toString(), PHP_EOL;
                foreach ($possibles as $r) {
                    echo '  Rect ' . $r->toString(), PHP_EOL;
                }
                $abGrid = array_fill(0, 2 * $maxCoord + 1, str_repeat('.', 2 * $maxCoord + 1));
                foreach ($possibles as $r) {
                    for ($a = $r->a0; $a <= $r->a1; ++$a) {
                        for ($b = $r->b0; $b <= $r->b1; ++$b) {
                            if (($a < -$maxCoord) or ($a > $maxCoord) or ($b < 0) or ($b > 2 * $maxCoord)) {
                                continue;
                            }
                            $abGrid[$b][$a + $maxCoord] = '+';
                        }
                    }
                }
                $s = str_repeat(' ', 5 + $maxCoord);
                for ($i = 0; $i <= $maxCoord; ++$i) {
                    $s .= strval($i % 10);
                }
                echo $s, PHP_EOL;
                foreach ($abGrid as $i => $line) {
                    $is = str_pad(strval($i), 2, ' ', STR_PAD_LEFT);
                    echo '  ' . $is . ' ' . $line . ' ' . $is, PHP_EOL;
                }
                echo $s, PHP_EOL;
                // @codeCoverageIgnoreEnd
            }
        }
        foreach ($possibles as $r) {
            if (($r->b0 != $r->b1) or ($r->a0 != $r->a1)) {
                continue;
            }
            $a = $r->a0;
            $b = $r->b0;
            if ((($a + $b) % 2 != 0) or (($a - $b) % 2 != 0)) {
                continue;
            }
            $x = intdiv($a + $b, 2);
            $y = $b - $x;
            if (
                ($x >= 0) and ($x <= $maxCoord)
                and ($y >= 0) and ($y <= $maxCoord)
            ) {
                $ans2 = $x * self::MAX_COORD_PART2 + $y;
                break;
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}

// --------------------------------------------------------------------
final class Sensor
{
    public int $x = 0;
    public int $y = 0;
    public int $beaconX = 0;
    public int $beaconY = 0;
    public int $distance = 0;

    /**
     * @codeCoverageIgnore
     */
    public function toString(): string
    {
        return '(' . $this->x . ',' . $this->y . ')-R' . $this->distance . '->B['
            . $this->beaconX . ',' . $this->beaconY . ']';
    }

    public static function fromString(string $s): self
    {
        $sensor = new self();
        $count = sscanf(
            $s,
            'Sensor at x=%d, y=%d: closest beacon is at x=%d, y=%d',
            $sensor->x,
            $sensor->y,
            $sensor->beaconX,
            $sensor->beaconY,
        );
        if ($count != 4) {
            throw new \Exception('Invalid input');
        }
        $sensor->distance = abs($sensor->x - $sensor->beaconX) + abs($sensor->y - $sensor->beaconY);
        return $sensor;
    }
}

// --------------------------------------------------------------------
/**
 * A rectangle shape in a coordinate system that is tilted by 45 degrees.
 *
 * a = x - y, b = x + y
 */
final class Rect
{
    public int $id;

    private static int $nextId = 0;

    public function __construct(
        public readonly int $a0,
        public readonly int $b0,
        public readonly int $a1,
        public readonly int $b1,
    ) {
        $this->id = self::$nextId;
        ++self::$nextId;
    }

    /**
     * @codeCoverageIgnore
     */
    public function toString(): string
    {
        return '#' . $this->id . ': (' . $this->a0 . ',' . $this->b0 . ') - (' . $this->a1 . ',' . $this->b1 . ')';
    }

    public static function fromXY(int $x0, int $y0, int $x1, int $y1): self
    {
        if ($x0 - $y0 <= $x1 - $y1) {
            return new self($x0 - $y0, $x0 + $y0, $x1 - $y1, $x1 + $y1);
        }
        return new self($x1 - $y1, $x1 + $y1, $x0 - $y0, $x0 + $y0);
    }

    public static function fromSensor(Sensor $s): self
    {
        return self::fromXY($s->x - $s->distance, $s->y, $s->x + $s->distance, $s->y);
    }

    /**
     * Substract a Rect from this Rect. The result is an array of remaining smaller Rects.
     *
     * @return array<int, Rect>
     */
    public function diff(Rect $r): array
    {
        if (($this->b1 < $r->b0) or ($r->b1 < $this->b0) or ($this->a1 < $r->a0) or ($r->a1 < $this->a0)) {
            return [$this];
        }
        $ans = [];
        if ($this->a0 < $r->a0) {
            $ans[] = new Rect($this->a0, $this->b0, $r->a0 - 1, $this->b1);
        }
        if ($r->a1 < $this->a1) {
            $ans[] = new Rect($r->a1 + 1, $this->b0, $this->a1, $this->b1);
        }
        if ($this->b0 < $r->b0) {
            $ans[] = new Rect(max($r->a0, $this->a0), $this->b0, min($r->a1, $this->a1), $r->b0 - 1);
        }
        if ($r->b1 < $this->b1) {
            $ans[] = new Rect(max($r->a0, $this->a0), $r->b1 + 1, min($r->a1, $this->a1), $this->b1);
        }
        return $ans;
    }
}

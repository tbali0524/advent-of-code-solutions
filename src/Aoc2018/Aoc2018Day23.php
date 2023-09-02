<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2018;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2018 Day 23: Experimental Emergency Teleportation.
 *
 * Part 1: Find the nanobot with the largest signal radius. How many nanobots are in range of its signals?
 * Part 2: What is the shortest manhattan distance between any of those points and 0,0,0?
 *
 * @see https://adventofcode.com/2018/day/23
 */
final class Aoc2018Day23 extends SolutionBase
{
    public const YEAR = 2018;
    public const DAY = 23;
    public const TITLE = 'Experimental Emergency Teleportation';
    public const SOLUTIONS = [599, 94481130];
    public const EXAMPLE_SOLUTIONS = [[7, 0], [0, 36]];

    private const OCTANTS = [
        [0, 0, 0],
        [0, 0, 1],
        [0, 1, 0],
        [0, 1, 1],
        [1, 0, 0],
        [1, 0, 1],
        [1, 1, 0],
        [1, 1, 1],
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
        $nanobots = array_map(static fn (string $line) => Nanobot::fromString($line), $input);
        // ---------- Part 1
        $ans1 = 0;
        usort($nanobots, static fn (Nanobot $a, Nanobot $b): int => $b->r <=> $a->r);
        $idxBest = array_key_first($nanobots);
        $bestBot = $nanobots[$idxBest];
        $ans1 = count(array_filter($nanobots, static fn (Nanobot $bot): bool => $bestBot->inRange($bot)));
        // ---------- Part 2
        $ans2 = 0;
        $maxRangeCoord = 0;
        foreach ($nanobots as $bot) {
            $c = $bot->maxRangeCoord();
            if ($c > $maxRangeCoord) {
                $maxRangeCoord = $c;
            }
        }
        $boxSize = 1;
        while ($boxSize <= $maxRangeCoord) {
            $boxSize <<= 1;
        }
        $cornerLow = new Point([-$boxSize, -$boxSize, -$boxSize]);
        $cornerHigh = new Point([$boxSize, $boxSize, $boxSize]);
        $count = count($nanobots);
        $size = 2 * $boxSize;
        $dist = $cornerLow->manhattanToOrigo();
        $priority = ($count << 52) + ($size << 26) + ((1 << 26) - $dist);
        /** @phpstan-var \SplPriorityQueue<int, array{int, int, int, Point, Point}> */
        $pq = new \SplPriorityQueue();
        $pq->insert([$count, $size, $dist, $cornerLow, $cornerHigh], $priority);
        while (true) {
            if ($pq->isEmpty()) {
                throw new \Exception('No solution found');
            }
            // @phpstan-ignore-next-line
            [$count, $size, $dist, $cornerLow, $cornerHigh] = $pq->extract();
            if ($size == 1) {
                $ans2 = $dist;
                break;
            }
            $newSize = $size >> 1;
            foreach (self::OCTANTS as $octant) {
                $newCornerLow = clone $cornerLow;
                for ($i = 0; $i < 3; ++$i) {
                    $newCornerLow->p[$i] += $octant[$i] * $newSize;
                }
                $newCornerHigh = clone $newCornerLow;
                for ($i = 0; $i < 3; ++$i) {
                    $newCornerHigh->p[$i] += $newSize;
                }
                $newDist = $newCornerLow->manhattanToOrigo();
                $newCount = count(array_filter(
                    $nanobots,
                    static fn (Nanobot $bot): bool => $bot->isIntersecting($newCornerLow, $newCornerHigh),
                ));
                $newPriority = ($newCount << 52) + ($newSize << 26) + ((1 << 26) - $newDist);
                $pq->insert([$newCount, $newSize, $newDist, $newCornerLow, $newCornerHigh], $newPriority);
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}

// --------------------------------------------------------------------
class Point
{
    public function __construct(
        /** @phpstan-var array{int, int, int} */
        public array $p = [0, 0, 0]
    ) {
    }

    public function manhattanToOrigo(): int
    {
        // @phpstan-ignore-next-line
        return intval(array_sum(array_map(abs(...), $this->p)));
    }
}

// --------------------------------------------------------------------
final class Nanobot extends Point
{
    public function __construct(
        int $x,
        int $y,
        int $z,
        public readonly int $r,
    ) {
        parent::__construct([$x, $y, $z]);
    }

    public function inRange(Point $point): bool
    {
        $dist = 0;
        for ($i = 0; $i < 3; ++$i) {
            $dist += abs($this->p[$i] - $point->p[$i]);
        }
        return $dist <= $this->r;
    }

    public function maxRangeCoord(): int
    {
        // @phpstan-ignore-next-line
        return intval(max(array_map(abs(...), $this->p))) + $this->r;
    }

    public function isIntersecting(Point $cornerLow, Point $cornerHigh): bool
    {
        $d = 0;
        for ($i = 0; $i < 3; ++$i) {
            $low = $cornerLow->p[$i];
            $high = $cornerHigh->p[$i] - 1;
            $d += abs($this->p[$i] - $low) + abs($this->p[$i] - $high);
            $d -= $high - $low;
        }
        $d = intdiv($d, 2);
        return $d <= $this->r;
    }

    public static function fromString(string $s): self
    {
        $count = sscanf($s, 'pos=<%d,%d,%d>, r=%d', $x, $y, $z, $r);
        if ($count != 4) {
            throw new \Exception('Invalid input');
        }
        return new self(intval($x), intval($y), intval($z), intval($r));
    }
}

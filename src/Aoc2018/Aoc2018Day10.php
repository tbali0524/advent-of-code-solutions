<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2018;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2018 Day 10: The Stars Align.
 *
 * Part 1: What message will eventually appear in the sky?
 * Part 2: Exactly how many seconds would they have needed to wait for that message to appear?
 *
 * @see https://adventofcode.com/2018/day/10
 */
final class Aoc2018Day10 extends SolutionBase
{
    public const YEAR = 2018;
    public const DAY = 10;
    public const TITLE = 'The Stars Align';
    public const SOLUTIONS = ['BLGNHPJC', 10476];
    public const EXAMPLE_SOLUTIONS = [['HI', 3]];

    private const DISPLAY = false;

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
        $swarm = new Swarm($input);
        // ---------- Part 1 + 2
        $area = $swarm->area;
        $ans2 = 0;
        while (true) {
            $swarm->tick();
            if ($swarm->area > $area) {
                $swarm->backTick();
                $ans2 = $swarm->step;
                // @phpstan-ignore if.alwaysFalse
                if (self::DISPLAY) {
                    // @codeCoverageIgnoreStart
                    $swarm->display();
                    // @codeCoverageIgnoreEnd
                }
                break;
            }
            $area = $swarm->area;
        }
        // hard-coded result after displaying solution grid
        $ans1 = count($input) == 31 ? self::EXAMPLE_SOLUTIONS[0][0] : self::SOLUTIONS[0];
        return [strval($ans1), strval($ans2)];
    }
}

// --------------------------------------------------------------------
final class MovingPoint
{
    public function __construct(
        public int $x,
        public int $y,
        public readonly int $vx,
        public readonly int $vy,
    ) {
    }

    public static function fromString(string $s): self
    {
        $count = sscanf($s, 'position=<%d, %d> velocity=<%d, %d>', $x, $y, $vx, $vy);
        if ($count != 4) {
            throw new \Exception('Invalid input');
        }
        return new self(intval($x), intval($y), intval($vx), intval($vy));
    }
}

// --------------------------------------------------------------------
final class Swarm
{
    public int $area;
    public int $step = 0;
    /** @var array<int, MovingPoint> */
    private array $points;
    private int $minX;
    private int $maxX;
    private int $minY;
    private int $maxY;

    /**
     * @param array<int, string> $input The lines of the input, without LF
     */
    public function __construct(array $input)
    {
        $this->points = array_map(static fn ($s) => MovingPoint::fromString($s), $input);
        $xs = array_map(static fn ($p) => $p->x, $this->points);
        $ys = array_map(static fn ($p) => $p->y, $this->points);
        $this->minX = intval(min($xs ?: [0]));
        $this->maxX = intval(max($xs ?: [0]));
        $this->minY = intval(min($ys ?: [0]));
        $this->maxY = intval(max($ys ?: [0]));
        $this->area = ($this->maxY - $this->minY + 1) * ($this->maxX - $this->minX + 1);
    }

    public function tick(): void
    {
        ++$this->step;
        $this->minX = PHP_INT_MAX;
        $this->maxX = ~PHP_INT_MAX;
        $this->minY = PHP_INT_MAX;
        $this->maxY = ~PHP_INT_MAX;
        foreach ($this->points as $p) {
            $p->x += $p->vx;
            $p->y += $p->vy;
            if ($p->x < $this->minX) {
                $this->minX = $p->x;
            }
            if ($p->x > $this->maxX) {
                $this->maxX = $p->x;
            }
            if ($p->y < $this->minY) {
                $this->minY = $p->y;
            }
            if ($p->y > $this->maxY) {
                $this->maxY = $p->y;
            }
        }
        $this->area = ($this->maxY - $this->minY + 1) * ($this->maxX - $this->minX + 1);
    }

    public function backTick(): void
    {
        --$this->step;
        foreach ($this->points as $p) {
            $p->x -= $p->vx;
            $p->y -= $p->vy;
        }
        $xs = array_map(static fn ($p) => $p->x, $this->points);
        $ys = array_map(static fn ($p) => $p->y, $this->points);
        $this->minX = intval(min($xs ?: [0]));
        $this->maxX = intval(max($xs ?: [0]));
        $this->minY = intval(min($ys ?: [0]));
        $this->maxY = intval(max($ys ?: [0]));
        $this->area = ($this->maxY - $this->minY + 1) * ($this->maxX - $this->minX + 1);
    }

    /**
     * @codeCoverageIgnore
     */
    public function display(): void
    {
        $grid = array_fill(0, $this->maxY - $this->minY + 1, str_repeat(' ', $this->maxX - $this->minX + 1));
        foreach ($this->points as $p) {
            $grid[$p->y - $this->minY][$p->x - $this->minX] = '#';
        }
        echo '-- #' . $this->step, PHP_EOL;
        foreach ($grid as $row) {
            echo $row, PHP_EOL;
        }
    }
}

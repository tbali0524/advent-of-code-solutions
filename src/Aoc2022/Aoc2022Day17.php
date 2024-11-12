<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2022;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2022 Day 17: Pyroclastic Flow.
 *
 * Part 1: How many units tall will the tower of rocks be after 2022 rocks have stopped falling?
 * Part 2: How tall will the tower be after 1000000000000 rocks have stopped?
 *
 * Topics: Tetris simulation, cycle detection
 *
 * @see https://adventofcode.com/2022/day/17
 */
final class Aoc2022Day17 extends SolutionBase
{
    public const YEAR = 2022;
    public const DAY = 17;
    public const TITLE = 'Pyroclastic Flow';
    public const SOLUTIONS = [3161, 1575931232076];
    public const EXAMPLE_SOLUTIONS = [[3068, 1514285714288]];
    public const EXAMPLE_STRING_INPUTS = ['>>><<><>><<<>><>>><<<>>><<<><<<>><>><<>>'];

    private const MAX_TURNS_PART1 = 2022;
    private const MAX_TURNS_PART2 = 1_000_000_000_000;

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
        $wind = $input[0] ?? throw new \Exception('Invalid input');
        // ---------- Part 1
        $pit = new Pit($wind);
        $ans1 = $pit->simulate(self::MAX_TURNS_PART1);
        // ---------- Part 2
        $pit = new MemoPit($wind);
        $ans2 = $pit->simulate(self::MAX_TURNS_PART2);
        return [strval($ans1), strval($ans2)];
    }
}

// --------------------------------------------------------------------
abstract class Rock
{
    public const int MAX_X = 1;
    public const int MAX_Y = 1;
    /** @var array<int, int> */
    public const array SHAPE = [0b1];
}

// --------------------------------------------------------------------
final class HorizontalRock extends Rock
{
    public const int MAX_X = 4;
    public const int MAX_Y = 1;
    /** @var array<int, int> */
    public const array SHAPE = [0b1111];
}

final class CrossRock extends Rock
{
    public const int MAX_X = 3;
    public const int MAX_Y = 3;
    /** @var array<int, int> */
    public const array SHAPE = [
        0b010,
        0b111,
        0b010,
    ];
}

final class LRock extends Rock
{
    public const int MAX_X = 3;
    public const int MAX_Y = 3;
    /** @var array<int, int> */
    public const array SHAPE = [
        0b111,
        0b100,
        0b100,
    ];
}

final class VerticalRock extends Rock
{
    public const int MAX_X = 1;
    public const int MAX_Y = 4;
    /** @var array<int, int> */
    public const array SHAPE = [
        0b1,
        0b1,
        0b1,
        0b1,
    ];
}

final class SquareRock extends Rock
{
    public const int MAX_X = 2;
    public const int MAX_Y = 2;
    /** @var array<int, int> */
    public const array SHAPE = [
        0b11,
        0b11,
    ];
}

// --------------------------------------------------------------------
class Pit
{
    public const bool DEBUG = false;

    public readonly int $maxX;
    public int $maxY = 0;
    /** @var array<int, int> */
    public array $shape = [];
    /** @var array<int, Rock> */
    protected readonly array $rocks;
    protected readonly string $wind;
    protected int $idxNextRock = 0;
    protected int $idxNextWind = 0;

    public function __construct(string $wind)
    {
        $this->maxX = 7;
        $this->wind = $wind;
        $this->rocks = [
            new HorizontalRock(),
            new CrossRock(),
            new LRock(),
            new VerticalRock(),
            new SquareRock(),
        ];
    }

    /**
     * @codeCoverageIgnore
     */
    public function printDebugPit(): void
    {
        $s = array_reverse(array_map(
            fn (int $x): string => strtr(strrev(str_pad(decbin($x), $this->maxX, '0', STR_PAD_LEFT)), '01', '.#'),
            $this->shape
        ));
        foreach ($s as $line) {
            echo $line, PHP_EOL;
        }
    }

    public function simulate(int $maxTurn = 1): int
    {
        for ($turn = 0; $turn < $maxTurn; ++$turn) {
            $rock = $this->rocks[$this->idxNextRock];
            $this->idxNextRock = ($this->idxNextRock + 1) % count($this->rocks);
            $this->simRock($rock);
            // @phpstan-ignore if.alwaysFalse
            if (self::DEBUG) {
                // @codeCoverageIgnoreStart
                echo '--- Pit after turn #' . $turn, PHP_EOL;
                $this->printDebugPit();
                // @codeCoverageIgnoreEnd
            }
        }
        return $this->maxY;
    }

    protected function canPutRockAt(Rock $rock, int $x0, int $y0): bool
    {
        if (($y0 < 0) or ($x0 < 0) or ($x0 + $rock::MAX_X > $this->maxX)) {
            return false;
        }
        for ($y = 0; $y < $rock::MAX_Y; ++$y) {
            $maskRockRow = $rock::SHAPE[$y] << $x0;
            $maskPitRow = $this->shape[$y0 + $y] ?? 0;
            if (($maskRockRow & $maskPitRow) != 0) {
                return false;
            }
        }
        return true;
    }

    protected function putRockAt(Rock $rock, int $x0 = 0, int $y0 = 0): void
    {
        if (!$this->canPutRockAt($rock, $x0, $y0)) {
            return;
        }
        for ($y = 0; $y < $rock::MAX_Y; ++$y) {
            if ($y0 + $y >= count($this->shape)) {
                $this->shape[] = 0;
                ++$this->maxY;
            }
            $maskRockRow = $rock::SHAPE[$y] << $x0;
            $maskPitRow = $this->shape[$y0 + $y];
            $this->shape[$y0 + $y] = $maskPitRow | $maskRockRow;
        }
    }

    protected function simRock(Rock $rock): void
    {
        $y = $this->maxY + 3;
        $x = 2;
        while (true) {
            if (strlen($this->wind) != 0) {
                $dx = ['>' => 1, '<' => -1][$this->wind[$this->idxNextWind]] ?? throw new \Exception('Invalid input');
                $this->idxNextWind = ($this->idxNextWind + 1) % strlen($this->wind);
                if ($this->canPutRockAt($rock, $x + $dx, $y)) {
                    $x += $dx;
                }
            }
            if (!$this->canPutRockAt($rock, $x, $y - 1)) {
                $this->putRockAt($rock, $x, $y);
                break;
            }
            --$y;
        }
    }
}

// --------------------------------------------------------------------
class MemoPit extends Pit
{
    /** @var array<int, array<int, int>> */
    private array $memo = [];

    public function getHash(): int
    {
        $hash = 0;
        $bit = 0;
        for ($y = $this->maxY - 6; $y < $this->maxY; ++$y) {
            $hash |= (($this->shape[$y] ?? 0b1111111) << $bit);
            $bit += 7;
        }
        $hash |= ($this->idxNextWind << 42) | ($this->idxNextRock << 56);
        return $hash;
    }

    public function simulate(int $maxTurn = 1): int
    {
        $extraY = 0;
        $foundCycle = false;
        for ($turn = 0; $turn < $maxTurn; ++$turn) {
            $rock = $this->rocks[$this->idxNextRock];
            $this->idxNextRock = ($this->idxNextRock + 1) % count($this->rocks);
            $this->simRock($rock);
            $hash = $this->getHash();
            if (!isset($this->memo[$hash])) {
                $this->memo[$hash] = [$turn, $this->maxY];
                continue;
            }
            if ($foundCycle) {
                continue;
            }
            $foundCycle = true;
            [$oldTurn, $oldY] = $this->memo[$hash];
            $cycleLen = $turn - $oldTurn;
            $cycleCount = intdiv($maxTurn - $turn, $cycleLen);
            $turn += $cycleCount * $cycleLen;
            $extraY = $cycleCount * ($this->maxY - $oldY);
        }
        return $this->maxY + $extraY;
    }
}

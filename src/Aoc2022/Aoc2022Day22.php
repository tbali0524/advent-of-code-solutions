<?php

declare(strict_types=1);

namespace TBali\Aoc2022;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2022 Day 22: Monkey Map.
 *
 * Part 1: Follow the path given in the monkeys' notes. What is the final password?
 * Part 2: Fold the map into a cube, then follow the path given in the monkeys' notes. What is the final password?
 *
 * Topics: walking simulation, cube geometry
 *
 * @see https://adventofcode.com/2022/day/22
 */
final class Aoc2022Day22 extends SolutionBase
{
    public const YEAR = 2022;
    public const DAY = 22;
    public const TITLE = 'Monkey Map';
    public const SOLUTIONS = [136054, 122153];
    public const EXAMPLE_SOLUTIONS = [[6032, 5031]];

    private const WALL = '#';
    private const RIGHT = 0;
    private const DOWN = 1;
    private const LEFT = 2;
    private const UP = 3;
    private const DELTA_XY = [
        self::RIGHT => [1, 0],
        self::DOWN => [0, 1],
        self::LEFT => [-1, 0],
        self::UP => [0, -1],
    ];
    private const DELTA_FACING = ['R' => 1, 'L' => -1];

    private int $maxX = 0;
    private int $maxY = 0;
    /** @var array<int, string> */
    private array $grid = [];
    /** @var array<int, int> */
    private array $rowFrom = [];
    /** @var array<int, int> */
    private array $rowTo = [];
    /** @var array<int, int> */
    private array $columnFrom = [];
    /** @var array<int, int> */
    private array $columnTo = [];
    /** @var array<int, int> */
    private array $moveBys = [];
    /** @var array<int, string> */
    private array $turnTos = [];
    private int $startX = 0;
    private int $startY = 0;
    private int $startFacing = 0;

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
        $this->parseInput($input);
        // ---------- Part 1
        $x = $this->startX;
        $y = $this->startY;
        $facing = $this->startFacing;
        foreach ($this->moveBys as $idxMove => $moveBy) {
            for ($i = 0; $i < $moveBy; ++$i) {
                [$dx, $dy] = self::DELTA_XY[$facing] ?? throw new \Exception('Impossible');
                $x1 = $x + $dx;
                if ($x1 < $this->rowFrom[$y]) {
                    $x1 = $this->rowTo[$y];
                } elseif ($x1 > $this->rowTo[$y]) {
                    $x1 = $this->rowFrom[$y];
                }
                $y1 = $y + $dy;
                if ($y1 < $this->columnFrom[$x]) {
                    $y1 = $this->columnTo[$x];
                } elseif ($y1 > $this->columnTo[$x]) {
                    $y1 = $this->columnFrom[$x];
                }
                if (($this->grid[$y1][$x1] ?? self::WALL) == self::WALL) {
                    break;
                }
                $x = $x1;
                $y = $y1;
            }
            $df = self::DELTA_FACING[$this->turnTos[$idxMove]] ?? 0;
            $facing = ($facing + $df + 4) % 4;
        }
        $ans1 = 1000 * ($y + 1) + 4 * ($x + 1) + $facing;
        // ---------- Part 2
        $x = $this->startX;
        $y = $this->startY;
        $facing = $this->startFacing;
        $size = intdiv(min($this->maxX, $this->maxY), 3);
        foreach ($this->moveBys as $idxMove => $moveBy) {
            for ($i = 0; $i < $moveBy; ++$i) {
                $cubeX = intdiv($x, $size);
                $cubeY = intdiv($y, $size);
                $modX = $x % $size;
                $modY = $y % $size;
                [$dx, $dy] = self::DELTA_XY[$facing] ?? throw new \Exception('Impossible');
                $x1 = $x + $dx;
                $y1 = $y + $dy;
                $facing1 = $facing;
                if ($this->maxX > $this->maxY) {
                    // ---- Folding as in example
                    if ($x1 < $this->rowFrom[$y]) {
                        // ---- LEFT
                        // $cubeY == 0         | $cubeY == 1         | $cubeY == 2         | N/A                 |
                        //     <1   .     11   |     11   .     11   |     11   .     11   |     11   .     11   |
                        //     11   .     11   |     11   .     11   |     11   .     11   |     11   .     11   |
                        // 22v344   . 223344   | <23344   . 223344   | 223344   . 223344   | 223344   . 223344   |
                        // 223344   . 223344   | 223344   . 223344   | 223344   . 223^44   | 223344   . 223344   |
                        //     5566 .     5566 |     5566 .     5566 |     <566 .     5566 |     5566 .     5566 |
                        //     5566 .     5566 |     5566 .     556^ |     5566 .     5566 |     5566 .     5566 |
                        [$x1, $y1, $facing1] = match ($cubeY) {
                            0 => [
                                $size + $modY,
                                $size,
                                self::DOWN,
                            ],
                            1 => [
                                4 * $size - 1 - $modY,
                                3 * $size - 1,
                                self::UP,
                            ],
                            2 => [
                                2 * $size - 1 - $modY,
                                2 * $size - 1,
                                self::UP,
                            ],
                            default => throw new \Exception('Impossible'),
                        };
                    } elseif ($x1 > $this->rowTo[$y]) {
                        // ---- RIGHT
                        // $cubeY == 0         | $cubeY == 1         | $cubeY == 2         | N/A                 |
                        //     1>   .     11   |     11   .     11   |     11   .     11   |     11   .     11   |
                        //     11   .     11   |     11   .     11   |     11   .     1<   |     11   .     11   |
                        // 223344   . 223344   | 22334>   . 223344   | 223344   . 223344   | 223344   . 223344   |
                        // 223344   . 223344   | 223344   . 223344   | 223344   . 223344   | 223344   . 223344   |
                        //     5566 .     5566 |     5566 .     556v |     556> .     5566 |     5566 .     5566 |
                        //     5566 .     556< |     5566 .     5566 |     5566 .     5566 |     5566 .     5566 |
                        [$x1, $y1, $facing1] = match ($cubeY) {
                            0 => [
                                4 * $size - 1,
                                3 * $size - 1 - $modY,
                                self::LEFT,
                            ],
                            1 => [
                                4 * $size - 1 - $modY,
                                2 * $size,
                                self::DOWN,
                            ],
                            2 => [
                                3 * $size - 1,
                                $size - 1 - $modY,
                                self::LEFT,
                            ],
                            default => throw new \Exception('Impossible'),
                        };
                    } elseif ($y1 < $this->columnFrom[$x]) {
                        // ---- UP
                        // $cubeX == 0         | $cubeX == 1         | $cubeX == 2         | $cubeX == 3         |
                        //     11   .     1v   |     11   .     >1   |     ^1   .     11   |     11   .     11   |
                        //     11   .     11   |     11   .     11   |     11   .     11   |     11   .     11   |
                        // ^23344   . 223344   | 22^344   . 223344   | 223344   . 2v3344   | 223344   . 223344   |
                        // 223344   . 223344   | 223344   . 223344   | 223344   . 223344   | 223344   . 22334<   |
                        //     5566 .     5566 |     5566 .     5566 |     5566 .     5566 |     55^6 .     5566 |
                        //     5566 .     5566 |     5566 .     5566 |     5566 .     5566 |     5566 .     5566 |
                        [$x1, $y1, $facing1] = match ($cubeX) {
                            0 => [
                                3 * $size - 1 - $modX,
                                0,
                                self::DOWN,
                            ],
                            1 => [
                                2 * $size,
                                $modX,
                                self::RIGHT,
                            ],
                            2 => [
                                $size - 1 - $modX,
                                $size,
                                self::DOWN,
                            ],
                            3 => [
                                3 * $size - 1,
                                2 * $size - 1 - $modX,
                                self::LEFT,
                            ],
                            default => throw new \Exception('Impossible'),
                        };
                    } elseif ($y1 > $this->columnTo[$x]) {
                        // ---- DOWN
                        // $cubeX == 0         | $cubeX == 1         | $cubeX == 2         | $cubeX == 3         |
                        //     11   .     11   |     11   .     11   |     11   .     11   |     11   .     11   |
                        //     11   .     11   |     11   .     11   |     11   .     11   |     11   .     11   |
                        // 223344   . 223344   | 223344   . 223344   | 223344   . 223344   | 223344   . 223344   |
                        // v23344   . 223344   | 22v344   . 223344   | 223344   . 2^3344   | 223344   . >23344   |
                        //     5566 .     5566 |     5566 .     5566 |     5566 .     5566 |     5566 .     5566 |
                        //     5566 .     5^66 |     5566 .     >566 |     v566 .     5566 |     55v6 .     5566 |
                        [$x1, $y1, $facing1] = match ($cubeX) {
                            0 => [
                                3 * $size - 1 - $modX,
                                3 * $size - 1,
                                self::UP,
                            ],
                            1 => [
                                2 * $size,
                                3 * $size - 1 - $modX,
                                self::RIGHT,
                            ],
                            2 => [
                                $size - 1 - $modX,
                                2 * $size - 1,
                                self::UP,
                            ],
                            3 => [
                                0,
                                2 * $size - 1 - $modX,
                                self::RIGHT,
                            ],
                            default => throw new \Exception('Impossible'),
                        };
                    }
                } else {
                    // ---- Folding as in input
                    if ($x1 < $this->rowFrom[$y]) {
                        // ---- LEFT
                        // $cubeY == 0         | $cubeY == 1         | $cubeY == 2         | $cubeY == 3         |
                        //   <122   .   1122   |   1122   .   1122   |   1122   .   1122   |   1122   .   v122   |
                        //   1122   .   1122   |   1122   .   1122   |   1122   .   >122   |   1122   .   1122   |
                        //   33     .   33     |   <3     .   33     |   33     .   33     |   33     .   33     |
                        //   33     .   33     |   33     .   33     |   33     .   33     |   33     .   33     |
                        // 4455     . 4455     | 4455     . v455     | <455     . 4455     | 4455     . 4455     |
                        // 4455     . >455     | 4455     . 4455     | 4455     . 4455     | 4455     . 4455     |
                        // 66       . 66       | 66       . 66       | 66       . 66       | <6       . 66       |
                        // 66       . 66       | 66       . 66       | 66       . 66       | 66       . 66       |
                        [$x1, $y1, $facing1] = match ($cubeY) {
                            0 => [
                                0,
                                3 * $size - 1 - $modY,
                                self::RIGHT,
                            ],
                            1 => [
                                $modY,
                                2 * $size,
                                self::DOWN,
                            ],
                            2 => [
                                $size,
                                $size - 1 - $modY,
                                self::RIGHT,
                            ],
                            3 => [
                                $size + $modY,
                                0,
                                self::DOWN,
                            ],
                            default => throw new \Exception('Impossible'),
                        };
                    } elseif ($x1 > $this->rowTo[$y]) {
                        // ---- RIGHT
                        // $cubeY == 0         | $cubeY == 1         | $cubeY == 2         | $cubeY == 3         |
                        //   112>   .   1122   |   1122   .   1122   |   1122   .   1122   |   1122   .   1122   |
                        //   1122   .   1122   |   1122   .   11^2   |   1122   .   112<   |   1122   .   1122   |
                        //   33     .   33     |   3>     .   33     |   33     .   33     |   33     .   33     |
                        //   33     .   33     |   33     .   33     |   33     .   33     |   33     .   33     |
                        // 4455     . 4455     | 4455     . 4455     | 445>     . 4455     | 4455     . 4455     |
                        // 4455     . 445<     | 4455     . 4455     | 4455     . 4455     | 4455     . 44^5     |
                        // 66       . 66       | 66       . 66       | 66       . 66       | 6>       . 66       |
                        // 66       . 66       | 66       . 66       | 66       . 66       | 66       . 66       |
                        [$x1, $y1, $facing1] = match ($cubeY) {
                            0 => [
                                2 * $size - 1,
                                3 * $size - 1 - $modY,
                                self::LEFT,
                            ],
                            1 => [
                                2 * $size + $modY,
                                $size - 1,
                                self::UP,
                            ],
                            2 => [
                                3 * $size - 1,
                                $size - 1 - $modY,
                                self::LEFT,
                            ],
                            3 => [
                                $size + $modY,
                                3 * $size - 1,
                                self::UP,
                            ],
                            default => throw new \Exception('Impossible'),
                        };
                    } elseif ($y1 < $this->columnFrom[$x]) {
                        // ---- UP
                        // $cubeX == 0         | $cubeX == 1         | $cubeY == X         | N/A                 |
                        //   1122   .   1122   |   ^122   .   1122   |   11^2   .   1122   |   1122   .   1122   |
                        //   1122   .   1122   |   1122   .   1122   |   1122   .   1122   |   1122   .   1122   |
                        //   33     .   >3     |   33     .   33     |   33     .   33     |   33     .   33     |
                        //   33     .   33     |   33     .   33     |   33     .   33     |   33     .   33     |
                        // ^455     . 4455     | 4455     . 4455     | 4455     . 4455     | 4455     . 4455     |
                        // 4455     . 4455     | 4455     . 4455     | 4455     . 4455     | 4455     . 4455     |
                        // 66       . 66       | 66       . >6       | 66       . 66       | 66       . 66       |
                        // 66       . 66       | 66       . 66       | 66       . ^6       | 66       . 66       |
                        [$x1, $y1, $facing1] = match ($cubeX) {
                            0 => [
                                $size,
                                $size + $modX,
                                self::RIGHT,
                            ],
                            1 => [
                                0,
                                3 * $size + $modX,
                                self::RIGHT,
                            ],
                            2 => [
                                $modX,
                                4 * $size - 1,
                                self::UP,
                            ],
                            default => throw new \Exception('Impossible'),
                        };
                    } elseif ($y1 > $this->columnTo[$x]) {
                        // ---- DOWN
                        // $cubeX == 0         | $cubeX == 1         | $cubeX == 2         | N/A                 |
                        //   1122   .   11v2   |   1122   .   1122   |   1122   .   1122   |   1122   .   1122   |
                        //   1122   .   1122   |   1122   .   1122   |   11v2   .   1122   |   1122   .   1122   |
                        //   33     .   33     |   33     .   33     |   33     .   3<     |   33     .   33     |
                        //   33     .   33     |   33     .   33     |   33     .   33     |   33     .   33     |
                        // 4455     . 4455     | 4455     . 4455     | 4455     . 4455     | 4455     . 4455     |
                        // 4455     . 4455     | 44v5     . 4455     | 4455     . 4455     | 4455     . 4455     |
                        // 66       . 66       | 66       . 6<       | 66       . 66       | 66       . 66       |
                        // v6       . 66       | 66       . 66       | 66       . 66       | 66       . 66       |
                        [$x1, $y1, $facing1] = match ($cubeX) {
                            0 => [
                                2 * $size + $modX,
                                0,
                                self::DOWN,
                            ],
                            1 => [
                                $size - 1,
                                3 * $size + $modX,
                                self::LEFT,
                            ],
                            2 => [
                                2 * $size - 1,
                                $size + $modX,
                                self::LEFT,
                            ],
                            default => throw new \Exception('Impossible'),
                        };
                    }
                }
                if (($this->grid[$y1][$x1] ?? self::WALL) == self::WALL) {
                    break;
                }
                $x = $x1;
                $y = $y1;
                $facing = $facing1;
            }
            $turnTo = $this->turnTos[$idxMove];
            $df = self::DELTA_FACING[$turnTo] ?? 0;
            $facing = ($facing + $df + 4) % 4;
        }
        $ans2 = 1000 * ($y + 1) + 4 * ($x + 1) + $facing;
        return [strval($ans1), strval($ans2)];
    }

    /**
     * Parse input.
     *
     * Sets grid, maxX, maxY, rowFrom, rowTo, columnFrom, columnTo, startX, startY, startFacing, moveBy, turnTo.
     *
     * @param array<int, string> $input The lines of the input, without LF
     */
    private function parseInput(array $input): void
    {
        $this->grid = [];
        $this->maxX = 0;
        $this->maxY = 0;
        $this->rowFrom = [];
        $this->rowTo = [];
        $this->columnFrom = [];
        $this->columnTo = [];
        $this->moveBys = [];
        $this->turnTos = [];
        $instr = '';
        for ($y = 0; $y < count($input); ++$y) {
            if ($input[$y] == '') {
                $this->maxY = $y;
                $instr = $input[$y + 1] ?? '';
                break;
            }
            $this->grid[$y] = $input[$y];
            $this->maxX = max($this->maxX, strlen($this->grid[$y]));
            $x = 0;
            while (($x < strlen($this->grid[$y])) and ($this->grid[$y][$x] == ' ')) {
                ++$x;
            }
            $this->rowFrom[$y] = $x;
            $x = strlen($this->grid[$y]) - 1;
            while (($x >= 0) and ($this->grid[$y][$x] == ' ')) {
                --$x;
            }
            $this->rowTo[$y] = $x;
            if ($this->rowTo[$y] - $this->rowFrom[$y] < 0) {
                throw new \Exception('Invalid input');
            }
        }
        for ($x = 0; $x < $this->maxX; ++$x) {
            $y = 0;
            while (($y < $this->maxY) and (($this->grid[$y][$x] ?? ' ') == ' ')) {
                ++$y;
            }
            $this->columnFrom[$x] = $y;
            $y = $this->maxY - 1;
            while (($y >= 0) and (($this->grid[$y][$x] ?? ' ') == ' ')) {
                --$y;
            }
            $this->columnTo[$x] = $y;
            if ($this->columnTo[$x] - $this->columnFrom[$x] < 0) {
                throw new \Exception('Invalid input');
            }
        }
        if (!isset($this->rowFrom[0]) or !isset($this->rowTo[0])) {
            throw new \Exception('Invalid input');
        }
        $this->startFacing = self::RIGHT;
        $this->startY = 0;
        $this->startX = $this->rowFrom[0];
        while (($this->startX <= $this->rowTo[0]) and ($this->grid[$this->startX] == '#')) {
            ++$this->startX;
        }
        if ($this->startX > $this->rowTo[0]) {
            throw new \Exception('Invalid input');
        }
        $posFrom = 0;
        while ($posFrom < strlen($instr)) {
            $posTo = $posFrom;
            while (($posTo < strlen($instr)) and !str_contains('LR', $instr[$posTo])) {
                ++$posTo;
            }
            if ($posTo == $posFrom) {
                throw new \Exception('Invalid input');
            }
            $this->moveBys[] = intval(substr($instr, $posFrom, $posTo - $posFrom));
            $this->turnTos[] = ($posTo < strlen($instr) ? $instr[$posTo] : ' ');
            $posFrom = $posTo + 1;
        }
        if (count($this->moveBys) == 0) {
            throw new \Exception('Invalid input');
        }
    }
}

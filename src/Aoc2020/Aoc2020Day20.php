<?php

// phpcs:disable PSR1.Classes.ClassDeclaration

declare(strict_types=1);

namespace TBali\Aoc2020;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2020 Day 20 - Jurassic Jigsaw.
 *
 * Part 1: What do you get if you multiply together the IDs of the four corner tiles?
 * Part 2:
 *
 * @see https://adventofcode.com/2020/day/20
 *
 * @todo Part 1 works for example, but too slow for puzzle input
 */
final class Aoc2020Day20 extends SolutionBase
{
    public const YEAR = 2020;
    public const DAY = 20;
    public const TITLE = 'Jurassic Jigsaw';
    public const SOLUTIONS = [0, 0];
    public const EXAMPLE_SOLUTIONS = [[20899048083289, 0], [0, 0]];

    private const DEBUG = true;

    private ImageTile $emptyTile;

    /** @var ImageTile[] */
    private array $tiles;
    private int $maxX;
    private int $maxY;

    /** @var array<int, ImageTile[]> */
    private array $validRightTiles;
    /** @var array<int, array<int, int>> */
    private array $validRightPos;
    /** @var array<int, ImageTile[]> */
    private array $validDownTiles;
    /** @var array<int, array<int, int>> */
    private array $validDownPos;

    /** @var array<int, int> */
    private array $edgeOccurences;

    /** @var array<ImageTile[]> */
    private array $gridTile;
    /** @var array<array<int, int>> */
    private array $gridPos;
    /** @var array<int, bool> */
    private array $assigned;

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
        $this->emptyTile = new ImageTile();
        $this->calculateNeighbors();
        $this->assigned = [];
        foreach ($this->tiles as $tile) {
            $this->assigned[$tile->id] = false;
        }
        $this->gridTile = array_fill(0, $this->maxY, array_fill(0, $this->maxX, $this->emptyTile));
        $this->gridPos = array_fill(0, $this->maxY, array_fill(0, $this->maxX, 0));
        if (count($this->tiles) > 10) {
            // return ['0', '0'];
        }
        if (self::DEBUG and (count($this->tiles) < 1000)) {
            echo '--- Empty tiles:', PHP_EOL;
            $this->printGrid();
            $seqTiles = array_values($this->tiles);
            for ($y = 0; $y < $this->maxY; ++$y) {
                for ($x = 0; $x < $this->maxX; ++$x) {
                    $this->gridTile[$y][$x] = $seqTiles[$y * $this->maxX + $x];
                }
            }
            echo '--- Tileset in initial positions:', PHP_EOL;
            $this->printGrid();
            for ($y = 0; $y < $this->maxY; ++$y) {
                for ($x = 0; $x < $this->maxX; ++$x) {
                    $this->gridTile[$y][$x] = $seqTiles[0];
                    $this->gridPos[$y][$x] = ($y * $this->maxX + $x) % 16;
                }
            }
            echo PHP_EOL;
            echo '--- First tile rotated and flipped:', PHP_EOL;
            $this->printGrid();
            echo PHP_EOL;
            $this->gridTile = array_fill(0, $this->maxY, array_fill(0, $this->maxX, $this->emptyTile));
            $this->gridPos = array_fill(0, $this->maxY, array_fill(0, $this->maxX, 0));
        }
        $result = $this->backtrack();
        if (!$result) {
            throw new \Exception('No solution found');
        }
        if (self::DEBUG and (count($this->tiles) < 1000)) {
            echo '--- Part 1 solution:', PHP_EOL;
            $this->printGrid();
        }
        // ---------- Part 1
        $ans1 = $this->gridTile[0][0]->id
            * $this->gridTile[0][$this->maxX - 1]->id
            * $this->gridTile[$this->maxY - 1][$this->maxX - 1]->id
            * $this->gridTile[$this->maxY - 1][0]->id;
        // ---------- Part 2
        $ans2 = 0;
        return [strval($ans1), strval($ans2)];
    }

    private function backtrack(int $x = -1, int $y = 0): bool
    {
        ++$x;
        if ($x == $this->maxX) {
            $x = 0;
            ++$y;
            if ($y == $this->maxY) {
                return true;
            }
        }
        if (self::DEBUG and (count($this->tiles) < 1000)) {
            if ($y > 5) {
                echo '--- Partial solution:', PHP_EOL;
                $this->printGrid();
            }
        }
        [$validTiles, $validPos] = $this->getValidTilesAndPos($x, $y);
        foreach ($validTiles as $idx => $tile) {
            if ($this->assigned[$tile->id] ?? false) {
                continue;
            }
            if ($y < $this->maxY - 1) {
                $downEdge = $tile->edges[$validPos[$idx]][ImageTile::DOWN];
                if (count($this->validDownTiles[$downEdge]) == 0) {
                    continue;
                }
            }
            $this->gridTile[$y][$x] = $tile;
            $this->gridPos[$y][$x] = $validPos[$idx];
            $this->assigned[$tile->id] = true;
            $result = $this->backtrack($x, $y);
            if ($result) {
                return true;
            }
            $this->assigned[$tile->id] = false;
        }
        return false;
    }

    /**
     * @return array<array<int, mixed>>
     *
     * @phpstan-return array{ImageTile[], array<int, int>}
     */
    private function getValidTilesAndPos(int $x, int $y): array
    {
        $validTiles = [];
        $validPos = [];
        if (($x == 0) and ($y == 0)) {
            foreach ($this->tiles as $tile) {
                for ($pos = 0; $pos < count($tile->edges); ++$pos) {
                    $validTiles[] = $tile;
                    $validPos[] = $pos;
                }
            }
        } elseif ($y == 0) {
            $leftEdge = $this->gridTile[0][$x - 1]->edges[$this->gridPos[$y][$x - 1]][ImageTile::RIGHT];
            $validTiles = $this->validRightTiles[$leftEdge] ?? [];
            $validPos = $this->validRightPos[$leftEdge] ?? [];
        } elseif ($x == 0) {
            $upEdge = $this->gridTile[$y - 1][0]->edges[$this->gridPos[$y - 1][$x]][ImageTile::DOWN];
            $validTiles = $this->validDownTiles[$upEdge] ?? [];
            $validPos = $this->validDownPos[$upEdge] ?? [];
        } else {
            $leftEdge = $this->gridTile[$y][$x - 1]->edges[$this->gridPos[$y][$x - 1]][ImageTile::RIGHT];
            $upEdge = $this->gridTile[$y - 1][$x]->edges[$this->gridPos[$y - 1][$x]][ImageTile::DOWN];
            foreach ($this->validRightTiles[$leftEdge] as $idx => $tile) {
                $pos = $this->validRightPos[$leftEdge][$idx];
                if ($tile->edges[$pos][ImageTile::UP] == $upEdge) {
                    $validTiles[] = $tile;
                    $validPos[] = $pos;
                }
            }
        }
        return [$validTiles, $validPos];
    }

    private function calculateNeighbors(): void
    {
        $this->validRightTiles = [];
        $this->validRightPos = [];
        $this->validDownTiles = [];
        $this->validDownPos = [];
        foreach ($this->tiles as $tile) {
            foreach ($tile->edges as $pos => $edges) {
                $this->validRightTiles[$edges[ImageTile::LEFT]][] = $tile;
                $this->validRightPos[$edges[ImageTile::LEFT]][] = $pos;
                $this->validDownTiles[$edges[ImageTile::UP]][] = $tile;
                $this->validDownPos[$edges[ImageTile::UP]][] = $pos;
            }
        }
    }

    private function getTopLeftTile(): void
    {
        $this->edgeOccurences = [];
        foreach ($this->tiles as $tile) {
            foreach ($tile->edges as $pos => $edges) {
                for ($i = 0; $i < 4; ++$i) {
                    $this->edgeOccurences[$edges[$i]] = ($this->edgeOccurences[$edges[$i]] ?? 0) + 1;
                }
            }
        }
        foreach ($this->tiles as $tile) {
            // TODO:
        }
    }


    private function printGrid(): void
    {
        $s = array_fill(0, $this->maxY * (ImageTile::SIZE + 1), str_repeat(' ', $this->maxX * (ImageTile::SIZE + 1)));
        for ($y = 0; $y < $this->maxY; ++$y) {
            for ($x = 0; $x < $this->maxX; ++$x) {
                $printedTile = $this->gridTile[$y][$x]->print($this->gridPos[$y][$x]);
                foreach ($printedTile as $idx => $line) {
                    $s[$y * (ImageTile::SIZE + 1) + $idx] = ImageTile::overlay(
                        $s[$y * (ImageTile::SIZE + 1) + $idx],
                        $x * (ImageTile::SIZE + 1),
                        $line
                    );
                }
            }
        }
        foreach ($s as $line) {
            echo $line, PHP_EOL;
        }
    }

    /**
     * @param array<int, string> $input
     */
    private function parseInput(array $input): void
    {
        $this->tiles = [];
        $idxLine = 0;
        while ($idxLine != count($input)) {
            $line = $input[$idxLine];
            if ($line == '') {
                ++$idxLine;
                continue;
            }
            if (
                (strlen($line) < 7)
                or !str_starts_with($line, 'Tile ')
                or ($line[strlen($line) - 1] != ':')
            ) {
                throw new \Exception('Invalid input');
            }
            $id = intval(substr($line, 5, -1));
            if (isset($this->tiles[$id])) {
                throw new \Exception('Invalid input');
            }
            if ($idxLine + ImageTile::SIZE >= count($input)) {
                throw new \Exception('Invalid input');
            }
            $grid = [];
            for ($i = 1; $i <= ImageTile::SIZE; ++$i) {
                $grid[] = $input[$idxLine + $i];
            }
            $this->tiles[$id] = new ImageTile($id, $grid);
            $idxLine += ImageTile::SIZE + 1;
        }
        $this->maxX = intval(sqrt(count($this->tiles)));
        $this->maxY = $this->maxX;
        if ($this->maxX * $this->maxY != count($this->tiles)) {
            throw new \Exception('Invalid input');
        }
    }
}

// --------------------------------------------------------------------
final class ImageTile
{
    public const SIZE = 10;
    public const UP = 0;
    public const RIGHT = 1;
    public const DOWN = 2;
    public const LEFT = 3;

    public readonly int $id;
    /** @var array<int, string> */
    public readonly array $grid;
    /** @var array<array<int, int>> */
    public array $edges;

    /** @param array<int, string> $grid */
    public function __construct(int $id = -1, array $grid = [])
    {
        if ($grid == []) {
            $id = -1;
            $grid = array_fill(0, self::SIZE, str_repeat('.', self::SIZE));
        }
        $this->id = $id;
        $this->grid = $grid;
        if (count($grid) != self::SIZE) {
            throw new \Exception('Invalid tile grid size');
        }
        if (count(array_filter($this->grid, fn (string $line): bool => strlen($line) != self::SIZE)) != 0) {
            throw new \Exception('Invalid tile grid size');
        }
        $this->calculateEdges();
    }

    /** @return array<int, string> */
    public function print(int $pos): array
    {
        $s = array_fill(0, self::SIZE, str_repeat(' ', self::SIZE));
        if ($this->id < 0) {
            $s[0] = '+' . str_repeat('-', self::SIZE - 2) . '+';
            for ($i = 1; $i < self::SIZE - 1; ++$i) {
                $s[$i][self::SIZE - 1] = '|';
                $s[$i][0] = '|';
            }
            $s[self::SIZE - 1] = $s[0];
            $s[2] = self::overlay($s[2], 2, '(EMPTY)');
            return $s;
        }
        $s[0] = strtr(str_pad(decbin($this->edges[$pos][self::UP]), self::SIZE, '0', STR_PAD_LEFT), '01', '.#');
        $s[self::SIZE - 1] = strtr(
            str_pad(decbin($this->edges[$pos][self::DOWN]), self::SIZE, '0', STR_PAD_LEFT),
            '01',
            '.#'
        );
        $right = strtr(str_pad(decbin($this->edges[$pos][self::RIGHT]), self::SIZE, '0', STR_PAD_LEFT), '01', '.#');
        $left = strtr(str_pad(decbin($this->edges[$pos][self::LEFT]), self::SIZE, '0', STR_PAD_LEFT), '01', '.#');
        for ($i = 0; $i < self::SIZE; ++$i) {
            $s[$i][self::SIZE - 1] = $right[$i];
            $s[$i][0] = $left[$i];
        }
        $s[2] = self::overlay($s[2], 2, '# ' . strval($this->id));
        $s[3] = self::overlay($s[3], 2, 'P:' . strval($pos));
        $s[4] = self::overlay($s[4], 2, '^ ' . strval($this->edges[$pos][self::UP]));
        $s[5] = self::overlay($s[5], 2, '> ' . strval($this->edges[$pos][self::RIGHT]));
        $s[6] = self::overlay($s[6], 2, '< ' . strval($this->edges[$pos][self::LEFT]));
        $s[7] = self::overlay($s[7], 2, 'v ' . strval($this->edges[$pos][self::DOWN]));
        return $s;
    }

    public static function overlay(string $base, int $from, string $msg): string
    {
        return substr($base, 0, $from) . $msg . substr($base, $from + strlen($msg));
    }

    private function calculateEdges(): void
    {
        $edgeStrings = [
            $this->grid[0] ?? '',
            '',
            $this->grid[self::SIZE - 1] ?? '',
            '',
        ];
        for ($i = 0; $i < self::SIZE; ++$i) {
            $edgeStrings[1] .= $this->grid[$i][self::SIZE - 1];
            $edgeStrings[3] .= $this->grid[$i][0];
        }
        $this->edges = [[]];
        foreach ($edgeStrings as $s) {
            $this->edges[0][] = intval(bindec(strtr($s, '.#', '01')));
        }
        $this->rotateLast();
        $this->edges[] = [
            self::mirror($this->edges[0][0]),
            $this->edges[0][3],
            self::mirror($this->edges[0][2]),
            $this->edges[0][1],
        ];
        $this->rotateLast();
        $this->edges[] = [
            $this->edges[0][2],
            self::mirror($this->edges[0][1]),
            $this->edges[0][0],
            self::mirror($this->edges[0][3]),
        ];
        $this->rotateLast();
        $this->edges[] = [
            self::mirror($this->edges[0][2]),
            self::mirror($this->edges[0][3]),
            self::mirror($this->edges[0][0]),
            self::mirror($this->edges[0][1]),
        ];
        $this->rotateLast();
    }

    private function rotateLast(): void
    {
        $idx = count($this->edges) - 1;
        if ($idx < 0) {
            throw new \Exception('Invalid rotate() call');
        }
        $this->edges[] = [
            self::mirror($this->edges[$idx][3]),
            $this->edges[$idx][0],
            self::mirror($this->edges[$idx][1]),
            $this->edges[$idx][2],
        ];
        $this->edges[] = [
            self::mirror($this->edges[$idx][2]),
            self::mirror($this->edges[$idx][3]),
            self::mirror($this->edges[$idx][0]),
            self::mirror($this->edges[$idx][1]),
        ];
        $this->edges[] = [
            $this->edges[$idx][1],
            self::mirror($this->edges[$idx][2]),
            $this->edges[$idx][3],
            self::mirror($this->edges[$idx][0]),
        ];
    }

    private static function mirror(int $edge): int
    {
        $ans = 0;
        for ($i = self::SIZE - 1; $i >= 0; --$i) {
            $ans |= ($edge & 1) << $i;
            $edge >>= 1;
        }
        return $ans;
    }
}

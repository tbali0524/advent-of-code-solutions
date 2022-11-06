<?php

// phpcs:disable PSR1.Classes.ClassDeclaration

declare(strict_types=1);

namespace TBali\Aoc2020;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2020 Day 20 - Jurassic Jigsaw.
 *
 * Part 1: What do you get if you multiply together the IDs of the four corner tiles?
 * Part 2: How many # are not part of a sea monster?
 *
 * @see https://adventofcode.com/2020/day/20
 */
final class Aoc2020Day20 extends SolutionBase
{
    public const YEAR = 2020;
    public const DAY = 20;
    public const TITLE = 'Jurassic Jigsaw';
    public const SOLUTIONS = [17250897231301, 1576];
    public const EXAMPLE_SOLUTIONS = [[20899048083289, 273], [0, 0]];

    public const DEBUG = false;
    private const MONSTER = [
        '                  # ',
        '#    ##    ##    ###',
        ' #  #  #  #  #  #   ',
    ];

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
    /** @var array<int, bool> */
    private array $isCornerTile;
    /** @var array<int, bool> */
    private array $isBorderTile;

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
        // ---------- Part 1
        $this->searchCornerAndBorderTiles();
        if (count($this->isCornerTile) == 0) {
            throw new \Exception('No solution found');
        }
        $ans1 = array_product(array_keys($this->isCornerTile));
        // ---------- Part 2
        $this->calculateNeighbors();
        $topLeft = $this->tiles[array_key_first($this->isCornerTile)] ?? $this->emptyTile;
        $result = false;
        for ($i = 0; $i < count($topLeft->edges); ++$i) {
            $this->gridTile = array_fill(0, $this->maxY, array_fill(0, $this->maxX, $this->emptyTile));
            $this->gridPos = array_fill(0, $this->maxY, array_fill(0, $this->maxX, 0));
            $this->assigned = [];
            foreach ($this->tiles as $tile) {
                $this->assigned[$tile->id] = false;
            }
            $this->gridTile[0][0] = $topLeft;
            $this->gridPos[0][0] = $i;
            $this->assigned[$topLeft->id] = true;
            $result = $this->backtrack(0, 0);
            if ($result) {
                break;
            }
        }
        if (!$result) {
            throw new \Exception('No solution found');
        }
        // @phpstan-ignore-next-line
        if (self::DEBUG) {
            echo '--- Reconstructed tiles:', PHP_EOL;
            $this->printDebugImage();
        }
        $image = Image::fromGridTile($this->gridTile, $this->gridPos);
        $monster = Image::fromStrings(self::MONSTER);
        $ans2 = $image->findMonsters($monster);
        return [strval($ans1), strval($ans2)];
    }

    /**
     * Gets list of valid tiles and orientations, based on a partially filled grid.
     *
     * Input: `tiles`.
     * Output: `isCornerTile, isBorderTile`.
     */
    private function searchCornerAndBorderTiles(): void
    {
        $this->isCornerTile = [];
        $this->isBorderTile = [];
        $edgeOccurences = [];
        foreach ($this->tiles as $tile) {
            for ($i = 0; $i < 4; ++$i) {
                $pos = $tile->edges[0][$i];
                $edgeOccurences[$pos] = ($edgeOccurences[$pos] ?? 0) + 1;
                $pos = ImageTile::mirror($pos);
                $edgeOccurences[$pos] = ($edgeOccurences[$pos] ?? 0) + 1;
            }
        }
        foreach ($this->tiles as $tile) {
            $count = 0;
            for ($i = 0; $i < 4; ++$i) {
                $pos = $tile->edges[0][$i];
                if ($edgeOccurences[$pos] % 2 == 1) {
                    ++$count;
                }
                $pos = ImageTile::mirror($pos);
                if ($edgeOccurences[$pos] % 2 == 1) {
                    ++$count;
                }
            }
            if ($count > 2) {
                $this->isCornerTile[$tile->id] = true;
            } elseif ($count == 2) {
                $this->isBorderTile[$tile->id] = true;
            }
        }
    }

    /**
     * Reconstructs the remainder of the image (recursive function).
     *
     * Input: `tiles, maxX, maxY,`
     *        `validRightTiles, validRightPos, validDownTiles, validDownPos, isCornerTile, isBorderTile`.
     * Output: `gridTile, gridPos`.
     * Also using `assigned` (must be prefilled with false befire first run).
     * Params x,y is the coordinate of the previously filled tile.
     * Top left corner must be pre-filled, otherwise too slow.
     *
     * @return bool The current partially filled grid led to a solution
     */
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
            if (
                (($x == 0) and ($y == 0))
                or (($x == $this->maxX - 1) and ($y == 0))
                or (($x == 0) and ($y == $this->maxY - 1))
                or (($x == $this->maxX - 1) and ($y == $this->maxY - 1))
            ) {
                if (!($this->isCornerTile[$tile->id] ?? false)) {
                    continue;
                }
            } elseif (($x == 0) or ($x == $this->maxX - 1) or ($y == 0) or ($y == $this->maxY - 1)) {
                if (!($this->isBorderTile[$tile->id] ?? false)) {
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
     * Gets list of valid tiles and orientations, based on a partially filled grid.
     *
     * Utility function used by backtrack. The grid must be filled above and left of the current grid.
     *
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

    /**
     * Creates lists of tiles that can be below, and right to each edge.
     *
     * Input: `tiles`.
     * Output: `validRightTiles, validRightPos, validDownTiles, validDownPos`.
     */
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

    private function printDebugImage(): void
    {
        $s = array_fill(0, $this->maxY * (ImageTile::SIZE + 1), str_repeat(' ', $this->maxX * (ImageTile::SIZE + 1)));
        for ($y = 0; $y < $this->maxY; ++$y) {
            for ($x = 0; $x < $this->maxX; ++$x) {
                $printedTile = $this->gridTile[$y][$x]->getDebugImage($this->gridPos[$y][$x]);
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
     * Creates tiles based on raw input.
     *
     * Output: `tiles, maxX, maxY`.
     *
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

    /**
     * 16 possible orientations, 4 edge in each (in UP,RIGHT,DOWN,LEFT order).
     *
     * Order of orientations: (normal, +3x rotated, flipX, +3x rotate, flipY, +3x rotated, flipXY, +3x rotated)
     *
     * @var array<array<int, int>>
     */
    public array $edges;

    /**
     * @param array<int, string> $grid
     */
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

    /**
     * @return array<int, string>
     */
    public function getInnerImage(): array
    {
        $ans = [];
        for ($y = 1; $y < self::SIZE - 1; ++$y) {
            $ans[] = substr($this->grid[$y], 1, -1);
        }
        return $ans;
    }

    /**
     * @param array<int, string> $image
     *
     * @return array<int, string>
     */
    public static function orientImage(array $image, int $pos = 0): array
    {
        $ans = match (intdiv($pos, 4)) {
            0 => $image,
            1 => self::flipX($image),
            2 => self::flipY($image),
            3 => self::flipY(self::flipX($image)),
            default => $image,
        };
        for ($i = 0; $i < $pos % 4; ++$i) {
            $ans = self::rotateRight($ans);
        }
        return $ans;
    }

    /**
     * @param array<int, string> $image
     *
     * @return array<int, string>
     */
    public static function rotateRight(array $image): array
    {
        $maxY = count($image);
        $maxX = strlen($image[0] ?? '');
        $ans = array_fill(0, $maxY, str_repeat(' ', $maxX));
        for ($y = 0; $y < $maxY; ++$y) {
            for ($x = 0; $x < $maxX; ++$x) {
                $ans[$x][$maxY - 1 - $y] = $image[$y][$x] ?? ' ';
            }
        }
        return $ans;
    }

    /**
     * @param array<int, string> $image
     *
     * @return array<int, string>
     */
    public static function flipX(array $image): array
    {
        $maxY = count($image);
        $ans = [];
        for ($y = 0; $y < $maxY; ++$y) {
            $ans[$y] = strrev($image[$y]);
        }
        return $ans;
    }

    /**
     * @param array<int, string> $image
     *
     * @return array<int, string>
     */
    public static function flipY(array $image): array
    {
        $maxY = count($image);
        $ans = [];
        for ($y = 0; $y < $maxY; ++$y) {
            $ans[$y] = $image[$maxY - 1 - $y];
        }
        return $ans;
    }

    /**
     * @return array<int, string>
     */
    public function getDebugImage(int $pos): array
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

    public static function mirror(int $edge): int
    {
        $ans = 0;
        for ($i = self::SIZE - 1; $i >= 0; --$i) {
            $ans |= ($edge & 1) << $i;
            $edge >>= 1;
        }
        return $ans;
    }

    /**
     * Helper function for the constructor.
     *
     * Output: `edges`.
     */
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

    /**
     * Helper function for the calculateEdges().
     *
     * Adds more 3 more orientations to the edges list.
     */
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
}

// --------------------------------------------------------------------
final class Image
{
    public readonly int $maxX;
    public readonly int $maxY;
    /** @var array<int, string> */
    public array $grid;

    public function __construct(int $maxX, int $maxY)
    {
        $this->maxX = $maxX;
        $this->maxY = $maxY;
        $this->grid = array_fill(0, $this->maxY, str_repeat(' ', $this->maxX));
    }

    /**
     * @param array<int, string> $image
     */
    public static function fromStrings(array $image): self
    {
        $maxY = count($image);
        $maxX = strlen($image[0] ?? '');
        $img = new self($maxX, $maxY);
        $img->grid = $image;
        return $img;
    }

    /**
     * @param array<ImageTile[]>     $gridTile
     * @param array<array<int, int>> $gridPos
     */
    public static function fromGridTile(array $gridTile, array $gridPos): self
    {
        if ($gridTile == []) {
            throw new \Exception('Impossible');
        }
        $maxY = count($gridTile) * (ImageTile::SIZE - 2);
        $maxX = count($gridTile[0]) * (ImageTile::SIZE - 2);
        $img = new self($maxX, $maxY);
        for ($y = 0; $y < count($gridTile); ++$y) {
            for ($x = 0; $x < count($gridTile[0]); ++$x) {
                $orientedGrid = ImageTile::orientImage($gridTile[$y][$x]->getInnerImage(), $gridPos[$y][$x]);
                foreach ($orientedGrid as $idx => $line) {
                    $img->grid[$y * (ImageTile::SIZE - 2) + $idx] = ImageTile::overlay(
                        $img->grid[$y * (ImageTile::SIZE - 2) + $idx],
                        $x * (ImageTile::SIZE - 2),
                        $line
                    );
                }
            }
        }
        return $img;
    }

    public function findMonsters(Image $monsterImage): int
    {
        $needle = new SearchPattern($monsterImage);
        $best = 0;
        $bestImg = new Image(0, 0);
        for ($pos = 0; $pos < 16; ++$pos) {
            $haystack = self::fromStrings(ImageTile::orientImage($this->grid, $pos));
            $result = $haystack->findIfOriented($needle);
            if ($result > $best) {
                $best = $result;
                $bestImg = $haystack;
            }
        }
        $total = array_sum(array_map(
            fn (string $line): int => substr_count($line, '#'),
            $this->grid,
        ));
        // @phpstan-ignore-next-line
        if (Aoc2020Day20::DEBUG) {
            echo '--- Image with proper orientation:', PHP_EOL;
            $bestImg->printImage();
        }
        return $total - $best;
    }

    public function printImage(): void
    {
        foreach ($this->grid as $line) {
            echo $line, PHP_EOL;
        }
        echo PHP_EOL;
    }

    private function findIfOriented(SearchPattern $monster): int
    {
        $ans = 0;
        for ($y = 0; $y < $this->maxY - $monster->maxY + 1; ++$y) {
            for ($x = 0; $x < $this->maxX - $monster->maxX + 1; ++$x) {
                $isOk = true;
                foreach ($monster->points as $p) {
                    if ($this->grid[$y + $p->y][$x + $p->x] != '#') {
                        $isOk = false;
                        break;
                    }
                }
                if (!$isOk) {
                    continue;
                }
                $ans += count($monster->points);
            }
        }
        return $ans;
    }
}

// --------------------------------------------------------------------
final class Point
{
    public function __construct(
        public readonly int $x,
        public readonly int $y,
    ) {
    }
}

// --------------------------------------------------------------------
final class SearchPattern
{
    public readonly int $maxX;
    public readonly int $maxY;
    /** @var array<int, Point> */
    public readonly array $points;

    public function __construct(Image $image)
    {
        $this->maxX = $image->maxX;
        $this->maxY = $image->maxY;
        $points = [];
        for ($y = 0; $y < $image->maxY; ++$y) {
            for ($x = 0; $x < $image->maxX; ++$x) {
                if ($image->grid[$y][$x] == '#') {
                    $points[] = new Point($x, $y);
                }
            }
        }
        $this->points = $points;
    }
}

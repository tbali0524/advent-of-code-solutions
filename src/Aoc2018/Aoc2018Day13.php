<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2018;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2018 Day 13: Mine Cart Madness.
 *
 * Part 1: To help prevent crashes, you'd like to know the location of the first crash.
 * Part 2: What is the location of the last cart at the end of the first tick where it is the only cart left?
 *
 * Topics: walk simulation
 *
 * @see https://adventofcode.com/2018/day/13
 *
 * @todo part 2 fails
 */
final class Aoc2018Day13 extends SolutionBase
{
    public const YEAR = 2018;
    public const DAY = 13;
    public const TITLE = 'Mine Cart Madness';
    public const SOLUTIONS = ['111,13', 0];
    public const EXAMPLE_SOLUTIONS = [['7,3', '0'], ['0', '6,4']];

    private const NORTH = 0; // must be increasing in clockwise order
    private const EAST = 1;
    private const SOUTH = 2;
    private const WEST = 3;
    private const DELTA_XY = [
        self::NORTH => [0, -1],
        self::EAST => [1, 0],
        self::SOUTH => [0, 1],
        self::WEST => [-1, 0],
    ];
    private const CART_FACINGS = ['^' => self::NORTH, '>' => self::EAST, 'v' => self::SOUTH, '<' => self::WEST];
    private const CART_TO_TRACK = ['^' => '|', '>' => '-', 'v' => '|', '<' => '-'];
    private const CART_TURNS = [-1, 0, 1]; // turn LEFT, go STRAIGHT, turn RIGHT
    private const TRACK_TURNS = [
        '/' => [
            self::NORTH => self::EAST,
            self::EAST => self::NORTH,
            self::SOUTH => self::WEST,
            self::WEST => self::SOUTH,
        ],
        '\\' => [
            self::NORTH => self::WEST,
            self::WEST => self::NORTH,
            self::SOUTH => self::EAST,
            self::EAST => self::SOUTH,
        ],
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
        // ---------- Parse input
        $carts = [];
        $map = [];
        $occupied = [];
        $idNext = 0;
        foreach ($input as $y => $line) {
            $map[$y] = $line;
            for ($x = 0; $x < strlen($line); ++$x) {
                if (!isset(self::CART_FACINGS[$line[$x]])) {
                    continue;
                }
                $carts[$idNext] = new Cart($idNext, $x, $y, self::CART_FACINGS[$line[$x]]);
                $map[$y][$x] = self::CART_TO_TRACK[$line[$x]];
                $hash = $x . ',' . $y;
                $occupied[$hash] = $idNext;
                ++$idNext;
            }
        }
        if (count($carts) < 2) {
            throw new \Exception('Invalid input');
        }
        // ---------- Part 1 + 2
        echo '---', PHP_EOL;
        $ans1 = '';
        $ans2 = '';
        $remainingCarts = count($carts);
        while (true) {
            foreach ($carts as $cart) {
                if ($cart->crashed) {
                    continue;
                }
                $tile = $map[$cart->y][$cart->x] ?? ' ';
                if ($tile == '+') {
                    $cart->facing = ($cart->facing + self::CART_TURNS[$cart->turnState] + 4) % 4;
                    $cart->turnState = ($cart->turnState + 1) % 3;
                } elseif (isset(self::TRACK_TURNS[$tile])) {
                    $cart->facing = self::TRACK_TURNS[$tile][$cart->facing];
                }
                [$dx, $dy] = self::DELTA_XY[$cart->facing];
                $hash = $cart->x . ',' . $cart->y;
                unset($occupied[$hash]);
                $cart->x += $dx;
                $cart->y += $dy;
                $hash = $cart->x . ',' . $cart->y;
                if (isset($occupied[$hash])) {
                    if ($remainingCarts == count($carts)) {
                        $ans1 = $hash;
                    }
                    echo "CRASH at {$hash} : {$cart->id} and {$carts[$occupied[$hash]]->id}", PHP_EOL;
                    $cart->crashed = true;
                    $carts[$occupied[$hash]]->crashed = true;
                    unset($occupied[$hash]);
                    $remainingCarts -= 2;
                } else {
                    $occupied[$hash] = $cart->id;
                }
            }
            if ($remainingCarts == 0) {
                $ans2 = '0';
                break;
            }
            if ($remainingCarts == 1) {
                $cart = array_values(array_filter($carts, fn (Cart $cart) => !$cart->crashed))[0];
                $ans2 = $cart->x . ',' . $cart->y;
                break;
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}

// --------------------------------------------------------------------
final class Cart
{
    public int $turnState = 0;
    public bool $crashed = false;

    public function __construct(
        public int $id,
        public int $x,
        public int $y,
        public int $facing,
    ) {
    }
}

<?php

declare(strict_types=1);

namespace TBali\Aoc2017;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2017 Day 21: Fractal Art.
 *
 * Part 1: How many pixels stay on after 5 iterations?
 * Part 2: How many pixels stay on after 18 iterations?
 *
 * Topics: image manipulation
 *
 * @see https://adventofcode.com/2017/day/21
 */
final class Aoc2017Day21 extends SolutionBase
{
    public const YEAR = 2017;
    public const DAY = 21;
    public const TITLE = 'Fractal Art';
    public const SOLUTIONS = [125, 1782917];
    public const EXAMPLE_SOLUTIONS = [[12, 12]];

    private const MAX_STEPS_EXAMPLE_PART1 = 2;
    private const MAX_STEPS_INPUT_PART1 = 5;
    private const MAX_STEPS_INPUT_PART2 = 18;
    private const LEN_TO_SIZE = [4 => 2, 9 => 3];
    private const START_IMAGE = '.#./..#/###';

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
        $inputRules = [];
        foreach ($input as $line) {
            $a = explode(' => ', $line);
            if (count($a) != 2) {
                throw new \Exception('Invalid input');
            }
            $inputRules[strtr($a[0], ['/' => ''])] = strtr($a[1], ['/' => '']);
        }
        // ---------- Part 1 + 2
        $ans1 = 0;
        $ans2 = 0;
        $rules = [];
        foreach ($inputRules as $fromPattern => $toPattern) {
            foreach (self::getOrientations($fromPattern) as $image) {
                $rules[$image] = $toPattern;
            }
        }
        $image = strtr(self::START_IMAGE, ['/' => '']);
        $size = 3;
        $part1Steps = count($inputRules) == 2 ? self::MAX_STEPS_EXAMPLE_PART1 : self::MAX_STEPS_INPUT_PART1;
        $maxSteps = count($inputRules) == 2 ? self::MAX_STEPS_EXAMPLE_PART1 : self::MAX_STEPS_INPUT_PART2;
        for ($step = 1; $step <= $maxSteps; ++$step) {
            $sizeTile = $size % 2 == 0 ? 2 : 3;
            $maxTile = intdiv($size, $sizeTile);
            $newSizeTile = $sizeTile + 1;
            $newSize = $maxTile * $newSizeTile;
            $newImage = str_repeat(' ', $newSize * $newSize);
            for ($y = 0; $y < $maxTile; ++$y) {
                for ($x = 0; $x < $maxTile; ++$x) {
                    $tile = '';
                    for ($yt = 0; $yt < $sizeTile; ++$yt) {
                        $tile .= substr($image, ($y * $sizeTile + $yt) * $size + $x * $sizeTile, $sizeTile);
                    }
                    $newTile = $rules[$tile] ?? throw new \Exception('No rule exists for this tile');
                    for ($yt = 0; $yt < $sizeTile + 1; ++$yt) {
                        for ($xt = 0; $xt < $sizeTile + 1; ++$xt) {
                            $newImage[($y * $newSizeTile + $yt) * $newSize + $x * $newSizeTile + $xt]
                                = $newTile[$yt * $newSizeTile + $xt];
                        }
                    }
                }
            }
            $image = $newImage;
            $size = $newSize;
            if ($step == $part1Steps) {
                $ans1 = array_count_values(str_split($image))['#'] ?? 0;
            }
        }
        $ans2 = array_count_values(str_split($image))['#'] ?? 0;
        return [strval($ans1), strval($ans2)];
    }

    private static function rotateRight(string $image): string
    {
        $size = self::LEN_TO_SIZE[strlen($image)] ?? throw new \Exception('Impossible');
        $ans = str_repeat(' ', strlen($image));
        for ($y = 0; $y < $size; ++$y) {
            for ($x = 0; $x < $size; ++$x) {
                $ans[$x * $size + $size - 1 - $y] = $image[$y * $size + $x] ?? ' ';
            }
        }
        return $ans;
    }

    private static function flipX(string $image): string
    {
        $size = self::LEN_TO_SIZE[strlen($image)] ?? throw new \Exception('Impossible');
        $ans = '';
        for ($y = 0; $y < $size; ++$y) {
            $ans .= strrev(substr($image, $y * $size, $size));
        }
        return $ans;
    }

    private static function flipY(string $image): string
    {
        $size = self::LEN_TO_SIZE[strlen($image)] ?? throw new \Exception('Impossible');
        $ans = '';
        for ($y = 0; $y < $size; ++$y) {
            $ans .= substr($image, ($size - 1 - $y) * $size, $size);
        }
        return $ans;
    }

    /**
     * @return array<int, string>
     */
    private static function getOrientations(string $image): array
    {
        $flips = [
            $image,
            self::flipX($image),
            self::flipY($image),
            self::flipY(self::flipX($image)),
        ];
        $ans = [];
        foreach ($flips as $image) {
            $ans[] = $image;
            for ($rotations = 1; $rotations < 4; ++$rotations) {
                $image = self::rotateRight($image);
                $ans[] = $image;
            }
        }
        return $ans;
    }

    /**
     * @codeCoverageIgnore
     *
     * @phpstan-ignore method.unused
     */
    private static function printImage(string $image): void
    {
        $size = intval(round(sqrt(strlen($image))));
        // @phpstan-ignore argument.type
        echo implode(PHP_EOL, str_split($image, $size)), PHP_EOL;
    }
}

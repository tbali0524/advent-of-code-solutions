<?php

declare(strict_types=1);

namespace TBali\Aoc2018;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2018 Day 20: A Regular Map.
 *
 * Part 1: What is the largest number of doors you would be required to pass through to reach a room?
 * Part 2: How many rooms have a shortest path from your current location that pass through at least 1000 doors?
 *
 * Topics: BFS, string parsing
 *
 * @see https://adventofcode.com/2018/day/20
 */
final class Aoc2018Day20 extends SolutionBase
{
    public const YEAR = 2018;
    public const DAY = 20;
    public const TITLE = 'A Regular Map';
    public const SOLUTIONS = [3991, 8394];
    public const EXAMPLE_SOLUTIONS = [[3, 0], [10, 0], [18, 0], [23, 0], [31, 0]];

    private const DELTA_XY = ['N' => [0, -1], 'E' => [1, 0], 'S' => [0, 1], 'W' => [-1, 0]];
    private const OPPOSITE_DIR = ['N' => 'S', 'E' => 'W', 'S' => 'N', 'W' => 'E'];
    private const THRESHOLD_PART2 = 1000;

    /** @var array<string, array<int, string>> */
    private array $doors;
    private string $regex;

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
        if ((count($input) != 1) or (strlen($input[0]) < 2) or ($input[0][0] != '^') or ($input[0][-1] != '$')) {
            throw new \Exception('Invalid input');
        }
        $this->regex = substr($input[0], 1, strlen($input[0]) - 2);
        // ---------- Part 1 + 2
        $this->exploreMap();
        $ans1 = 0;
        $ans2 = 0;
        $x = 0;
        $y = 0;
        $depth = 0;
        $xy = $x . ' ' . $y;
        $visited = [$xy => true];
        $q = [[$x, $y, $depth]];
        $readIdx = 0;
        while (true) {
            if ($readIdx >= count($q)) {
                break;
            }
            [$x, $y, $depth] = $q[$readIdx];
            ++$readIdx;
            if ($depth > $ans1) {
                $ans1 = $depth;
            }
            if ($depth >= self::THRESHOLD_PART2) {
                // @codeCoverageIgnoreStart
                ++$ans2;
                // @codeCoverageIgnoreEnd
            }
            $xy = $x . ' ' . $y;
            foreach ($this->doors[$xy] as $dir) {
                [$dx, $dy] = self::DELTA_XY[$dir] ?? throw new \Exception('Invalid input');
                $x1 = $x + $dx;
                $y1 = $y + $dy;
                $xy1 = $x1 . ' ' . $y1;
                if (isset($visited[$xy1])) {
                    continue;
                }
                $visited[$xy1] = true;
                $q[] = [$x1, $y1, $depth + 1];
            }
        }
        return [strval($ans1), strval($ans2)];
    }

    private function exploreMap(): void
    {
        $this->doors = [];
        $x = 0;
        $y = 0;
        $pos = 0;
        $xy = $x . ' ' . $y;
        $hash = $xy . $pos;
        $visited = [$hash => true];
        $q = [[$x, $y, $pos]];
        $readIdx = 0;
        while (true) {
            if ($readIdx >= count($q)) {
                break;
            }
            [$x, $y, $pos] = $q[$readIdx];
            ++$readIdx;
            while (true) {
                if ($pos >= strlen($this->regex)) {
                    break;
                }
                $char = $this->regex[$pos];
                if ($char == '(') {
                    // start of alternatives section, put alternatives to the queue
                    while (true) {
                        ++$pos;
                        $q[] = [$x, $y, $pos];
                        if ($this->regex[$pos] == ')') {
                            break;
                        }
                        // skip ahead to start of next alternative
                        $pos = $this->findPosNextAlternative($pos);
                        if ($this->regex[$pos] == ')') {
                            break;
                        }
                    }
                    // do not process the current queue item further, all alternatives are put back into the queue
                    break;
                }
                if ($char == '|') {
                    $pos = $this->findPosAfterAlternatives($pos);
                    continue;
                }
                if ($char == ')') {
                    ++$pos;
                    continue;
                }
                $xy = $x . ' ' . $y;
                [$dx, $dy] = self::DELTA_XY[$char] ?? throw new \Exception('Invalid input');
                $x1 = $x + $dx;
                $y1 = $y + $dy;
                $xy1 = $x1 . ' ' . $y1;
                $this->doors[$xy][] = $char;
                $this->doors[$xy1][] = self::OPPOSITE_DIR[$char];
                $x = $x1;
                $y = $y1;
                ++$pos;
                $hash = $xy1 . ' ' . $pos;
                if (isset($visited[$hash])) {
                    break;
                }
                $visited[$hash] = true;
            }
        }
    }

    private function findPosNextAlternative(int $pos): int
    {
        $parLevel = 0;
        while (true) {
            ++$pos;
            if (($parLevel < 0) or ($pos >= strlen($this->regex))) {
                throw new \Exception('Invalid input');
            }
            if (($parLevel == 0) and ($this->regex[$pos] == ')')) {
                return $pos;
            }
            if (($parLevel == 0) and ($this->regex[$pos] == '|')) {
                return $pos;
            }
            if ($this->regex[$pos] == '(') {
                ++$parLevel;
                continue;
            }
            if ($this->regex[$pos] == ')') {
                --$parLevel;
            }
        }
    }

    private function findPosAfterAlternatives(int $pos): int
    {
        $parLevel = 0;
        while (true) {
            ++$pos;
            if (($parLevel < 0) or ($pos >= strlen($this->regex))) {
                // @codeCoverageIgnoreStart
                throw new \Exception('Invalid input');
                // @codeCoverageIgnoreEnd
            }
            if (($parLevel == 0) and ($this->regex[$pos] == ')')) {
                return $pos + 1;
            }
            if ($this->regex[$pos] == '(') {
                ++$parLevel;
                continue;
            }
            if ($this->regex[$pos] == ')') {
                --$parLevel;
            }
        }
    }
}

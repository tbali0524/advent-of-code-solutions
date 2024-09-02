<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2022;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2022 Day 7: No Space Left On Device.
 *
 * Part 1: Find all of the directories with a total size of at most 100000.
 *         What is the sum of the total sizes of those directories?
 * Part 2: Find the smallest directory that, if deleted, would free up enough space on the filesystem
 *         to run the update. What is the total size of that directory?
 *
 * @see https://adventofcode.com/2022/day/7
 */
final class Aoc2022Day07 extends SolutionBase
{
    public const YEAR = 2022;
    public const DAY = 7;
    public const TITLE = 'No Space Left On Device';
    public const SOLUTIONS = [1390824, 7490863];
    public const EXAMPLE_SOLUTIONS = [[95437, 24933642]];

    private const DIR_LIMIT = 100_000;
    private const TOTAL_SPACE = 70_000_000;
    private const SPACE_NEEDED = 30_000_000;

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
        $root = $this->parseInput($input);
        // ---------- Part 1 + 2
        $root->updateTotalSize();
        $ans1 = $root->getTotalDirsBelow(self::DIR_LIMIT);
        $extraNeeded = $root->totalSize - (self::TOTAL_SPACE - self::SPACE_NEEDED);
        $ans2 = $root->getSmallestDirAbove($extraNeeded);
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param array<int, string> $input The lines of the input, without LF
     */
    private function parseInput(array $input): Directory
    {
        $root = new Directory('/');
        $workdir = $root;
        $i = -1;
        while ($i < count($input) - 1) {
            ++$i;
            $a = explode(' ', $input[$i]);
            if ((count($a) < 2) or ($a[0] != '$')) {
                throw new \Exception('Invalid input');
            }
            if (($a[1] == 'cd') and (count($a) == 3)) {
                if ($a[2] == '/') {
                    $workdir = $root;
                } elseif ($a[2] == '..') {
                    if (is_null($workdir->parent)) {
                        // @codeCoverageIgnoreStart
                        throw new \Exception('Invalid input');
                        // @codeCoverageIgnoreEnd
                    }
                    $workdir = $workdir->parent;
                } else {
                    if (!$workdir->wasListed or !isset($workdir->subdirs[$a[2]])) {
                        throw new \Exception('Invalid input');
                    }
                    $workdir = $workdir->subdirs[$a[2]];
                }
                continue;
            }
            if (($a[1] == 'ls') and (count($a) == 2)) {
                while (true) {
                    ++$i;
                    if (($i >= count($input)) or ($input[$i][0] == '$')) {
                        break;
                    }
                    if ($workdir->wasListed) {
                        continue;
                    }
                    $b = explode(' ', $input[$i]);
                    if (count($b) != 2) {
                        throw new \Exception('Invalid input');
                    }
                    if ($b[0] == 'dir') {
                        if (isset($workdir->subdirs[$b[1]])) {
                            // @codeCoverageIgnoreStart
                            throw new \Exception('Invalid input');
                            // @codeCoverageIgnoreEnd
                        }
                        $workdir->subdirs[$b[1]] = new Directory($b[1], $workdir);
                    } else {
                        $workdir->files[] = new File($b[1], intval($b[0]));
                    }
                }
                --$i;
                $workdir->wasListed = true;
                continue;
            }
            throw new \Exception('Invalid input');
        }
        return $root;
    }
}

// --------------------------------------------------------------------
final class File
{
    public function __construct(
        public readonly string $name,
        public readonly int $size,
    ) {
    }
}

// --------------------------------------------------------------------
final class Directory
{
    public string $name = '';
    public ?Directory $parent;
    /** @var array<string, Directory> */
    public array $subdirs = [];
    /** @var array<int, File> */
    public array $files = [];
    public bool $wasListed = false;
    public int $totalSize = 0;

    public function __construct(string $name, ?self $parent = null)
    {
        $this->name = $name;
        $this->parent = $parent;
    }

    public function updateTotalSize(): void
    {
        $this->totalSize = array_sum(array_map(static fn (File $x): int => $x->size, $this->files));
        foreach ($this->subdirs as $dir) {
            $dir->updateTotalSize();
            $this->totalSize += $dir->totalSize;
        }
    }

    public function getTotalDirsBelow(int $limit): int
    {
        $ans = 0;
        foreach ($this->subdirs as $dir) {
            $ans += $dir->getTotalDirsBelow($limit);
        }
        if ($this->totalSize <= $limit) {
            $ans += $this->totalSize;
        }
        return $ans;
    }

    public function getSmallestDirAbove(int $limit): int
    {
        $ans = PHP_INT_MAX;
        foreach ($this->subdirs as $dir) {
            $ans = min($ans, $dir->getSmallestDirAbove($limit));
        }
        if ($this->totalSize >= $limit) {
            $ans = min($ans, $this->totalSize);
        }
        return $ans;
    }
}

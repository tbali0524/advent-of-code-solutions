<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2018;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2018 Day 8: Memory Maneuver.
 *
 * Part 1: What is the sum of all metadata entries?
 * Part 2: What is the value of the root node?
 *
 * Topics: tree graph
 *
 * @see https://adventofcode.com/2018/day/8
 */
final class Aoc2018Day08 extends SolutionBase
{
    public const YEAR = 2018;
    public const DAY = 8;
    public const TITLE = 'Memory Maneuver';
    public const SOLUTIONS = [47244, 17267];
    public const EXAMPLE_SOLUTIONS = [[138, 66]];

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
        $data = array_map(intval(...), explode(' ', $input[0] ?? ''));
        // ---------- Part 1 + 2
        $root = TreeNode::fromArray($data);
        $ans1 = $root->sumMetadata();
        $ans2 = $root->getValue();
        return [strval($ans1), strval($ans2)];
    }
}

// --------------------------------------------------------------------
final class TreeNode
{
    public int $from = 0;
    public int $to = 0;
    /** @var array<int, TreeNode> */
    public array $children = [];
    /** @var array<int, int> */
    public array $metadata = [];

    public function __construct(int $from = 0)
    {
        $this->from = $from;
    }

    public function sumMetadata(): int
    {
        $ans = array_sum($this->metadata);
        foreach ($this->children as $child) {
            $ans += $child->sumMetadata();
        }
        return $ans;
    }

    public function getValue(): int
    {
        if (count($this->children) == 0) {
            return array_sum($this->metadata);
        }
        $ans = 0;
        foreach ($this->metadata as $meta) {
            if (($meta > count($this->children)) or ($meta <= 0)) {
                continue;
            }
            $ans += $this->children[$meta - 1]->getValue();
        }
        return $ans;
    }

    /** @param array<int, int> $data */
    public static function fromArray(array $data, int $from = 0): self
    {
        $node = new self($from);
        $countChildren = $data[$from] ?? 0;
        $countMetadata = $data[$from + 1] ?? 0;
        $from += 2;
        for ($i = 0; $i < $countChildren; ++$i) {
            $child = self::fromArray($data, $from);
            $node->children[] = $child;
            $from = $child->to;
        }
        $node->metadata = array_slice($data, $from, $countMetadata);
        $node->to = $from + $countMetadata;
        return $node;
    }
}

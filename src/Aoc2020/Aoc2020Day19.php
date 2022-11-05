<?php

// phpcs:disable PSR1.Classes.ClassDeclaration

declare(strict_types=1);

namespace TBali\Aoc2020;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2020 Day 19: Monster Message.
 *
 * Part 1: How many messages completely match rule 0?
 * Part 2: After updating rules 8 and 11, how many messages completely match rule 0?
 *
 * Topics: input parsing, context-free grammar, CGF with limited loops
 *
 * @see https://adventofcode.com/2020/day/19
 */
final class Aoc2020Day19 extends SolutionBase
{
    public const YEAR = 2020;
    public const DAY = 19;
    public const TITLE = 'Monster Message';
    public const SOLUTIONS = [272, 374];
    public const EXAMPLE_SOLUTIONS = [[2, 0], [3, 0]];

    /** @var MessageNode[] */
    private array $nodes;
    /** @var array<int, string> */
    private array $messages;
    /** @var array<int, array<string, int>> */
    private array $generates;

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
        // ---------- Part 1
        $this->parseInput($input);
        $maxLen = max(array_map('strlen', $this->messages)) ?: 0;
        $this->generates = [];
        $allStrings = array_keys($this->getAllGenerated(0, $maxLen));
        $ans1 = count(array_filter(
            $this->messages,
            fn (string $x): bool => in_array($x, $allStrings),
        ));
        // ---------- Part 2
        // detect puzzle example #1, valid for Part 1 only
        if (!isset($this->nodes[8])) {
            return [strval($ans1), '0'];
        }
        // Note: in both the puzzle and in Example #2:
        //      $this->nodes[0] == MessageNode('0: 8 11')
        $this->nodes[8] = new MessageNode('8: 42 | 42 8');
        $this->nodes[11] = new MessageNode('11: 42 31 | 42 11 31');
        $this->generates = [];
        $this->getAllGenerated(42, $maxLen);
        $this->getAllGenerated(31, $maxLen);
        $ans2 = 0;
        // @phpstan-ignore-next-line
        if ((count($this->generates[42] ?? []) == 0) or (count($this->generates[31] ?? []) == 0)) {
            throw new \Exception('No solution found');
        }
        // @phpstan-ignore-next-line
        $len42 = strlen(array_key_first($this->generates[42]));
        $len31 = strlen(array_key_first($this->generates[31]));
        foreach ($this->messages as $message) {
            $posLeft = 0;
            $count42 = 0;
            while (isset($this->generates[42][substr($message, $posLeft, $len42)])) {
                $posLeft += $len42;
                ++$count42;
            }
            if ($count42 < 2) {
                continue;
            }
            $posRight = strlen($message);
            $count31 = 0;
            while (isset($this->generates[31][substr($message, $posRight - $len31, $len31)])) {
                $posRight -= $len31;
                ++$count31;
            }
            if (($count31 == 0) or ($count42 <= $count31) or ($posLeft != $posRight)) {
                continue;
            }
            ++$ans2;
        }
        return [strval($ans1), strval($ans2)];
    }

    /** @return array<string, int> */
    private function getAllGenerated(int $idxNode, int $maxLen = 0): array
    {
        if (isset($this->generates[$idxNode])) {
            return $this->generates[$idxNode];
        }
        $node = $this->nodes[$idxNode];
        if ($node->match != '') {
            $this->generates[$idxNode] = [$node->match => -1];    // as keys
            return $this->generates[$idxNode];
        }
        $this->generates[$idxNode] = [];
        foreach ($node->subNodes as $subNodeList) {
            $candidates = ['' => -1];
            foreach ($subNodeList as $idxSubNode) {
                if ($idxSubNode == $idxNode) {
                    foreach ($candidates as $candidate => $loopLocation) {
                        if ($loopLocation >= 0) {
                            throw new \Exception('Multiple loops within a rule is not supported');
                        }
                        $candidates[$candidate] = strlen($candidate);
                    }
                    continue;
                }
                $subNodeGenerates = $this->getAllGenerated($idxSubNode, $maxLen);    // as keys
                $newCandidates = [];    // as keys
                foreach ($candidates as $candidate => $loopLocation) {
                    if (($maxLen > 0) and (strlen($candidate) >= $maxLen)) {
                        continue;
                    }
                    foreach ($subNodeGenerates as $segment => $segmentLoopLocation) {
                        if ($segmentLoopLocation >= 0) {
                            throw new \Exception('Multiple loops within a single expansion is not supported');
                        }
                        $newCandidate = $candidate . $segment;
                        if (!isset($newCandidates[$newCandidate])) {
                            $newCandidates[$newCandidate] = $loopLocation;
                        }
                    }
                }
                $candidates = $newCandidates;
            }
            foreach ($candidates as $candidate => $loopLocation) {
                if ($loopLocation < 0) {
                    $this->generates[$idxNode][$candidate] = -1;
                    continue;
                }
                throw new \Exception('Cannot generated all strings in case of a loop');
            }
        }
        return $this->generates[$idxNode];
    }

    /**
     * @param array<int, string> $input
     */
    private function parseInput(array $input): void
    {
        $this->nodes = [];
        $this->messages = [];
        $idxStartMsg = 0;
        foreach ($input as $line) {
            ++$idxStartMsg;
            if ($line == '') {
                break;
            }
            $node = new MessageNode($line);
            $this->nodes[$node->id] = $node;
        }
        for ($i = $idxStartMsg; $i < count($input); ++$i) {
            $this->messages[] = $input[$i];
        }
    }
}

// --------------------------------------------------------------------
final class MessageNode
{
    public readonly int $id;
    public readonly string $match;
    /** @var array<array<int, int>> */
    public array $subNodes;

    public function __construct(string $line)
    {
        $a = explode(': ', $line);
        if (count($a) != 2) {
            throw new \Exception('Invalid input');
        }
        $this->id = intval($a[0]);
        $this->subNodes = [];
        if ($a[1][0] == '"') {
            if (strlen($a[1]) < 3) {
                throw new \Exception('Invalid input');
            }
            $this->match = substr($a[1], 1, -1);
            return;
        }
        // @phpstan-ignore-next-line
        $this->match = '';
        $b = explode(' | ', $a[1]);
        foreach ($b as $list) {
            $this->subNodes[] = array_map('intval', explode(' ', $list));
        }
    }
}

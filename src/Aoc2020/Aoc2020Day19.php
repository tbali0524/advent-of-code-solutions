<?php

/*
https://adventofcode.com/2020/day/19
Part 1: How many messages completely match rule 0?
Part 2:
Topics: input parsing, generative grammar
*/

// phpcs:disable PSR1.Classes.ClassDeclaration

declare(strict_types=1);

namespace TBali\Aoc2020;

use TBali\Aoc\SolutionBase;

final class Aoc2020Day19 extends SolutionBase
{
    public const YEAR = 2020;
    public const DAY = 19;
    public const TITLE = 'Monster Message';
    public const SOLUTIONS = [272, 0];
    public const EXAMPLE_SOLUTIONS = [[2, 0], [3, 0]];

    /** @var MessageNode[] */
    private array $nodes;
    /** @var string[] */
    private array $messages;
    /** @var array<int, <array<string, int>> */
    private array $generates;

    /**
     * @param string[] $input
     *
     * @return array{string, string}
     */
    public function solve(array $input): array
    {
        // ---------- Part 1
        $this->parseInput($input);
        $this->generates = [];
        $allStrings = array_keys($this->getAllGenerated(0));
        $ans1 = count(array_filter(
            $this->messages,
            fn ($x) => in_array($x, $allStrings),
        ));
        // ---------- Part 2
        // detect puzzle example valid for Part 1 only
        if (!isset($this->nodes[8])) {
            return [strval($ans1), '0'];
        }
        $this->nodes[8] = new MessageNode('8: 42 | 42 8');
        $this->nodes[11] = new MessageNode('11: 42 31 | 42 11 31');
        $this->generates = [];
        $maxLen = max(array_map('strlen', $this->messages));
        $ans2 = 0;
        $allStrings = array_keys($this->getAllGenerated(0, $maxLen));
        $ans2 = count(array_filter(
            $this->messages,
            fn ($x) => in_array($x, $allStrings),
        ));
        return [strval($ans1), strval($ans2)];
    }

    /** @param array<string, int> */
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
                    foreach ($candidates as $candidate => $value) {
                        $candidates[$candidates] = strlen($candidate);
                    }
                }
                $subNodeGenerates = $this->getAllGenerated($idxSubNode);    // as keys
                $newCandidates = [];    // as keys
                foreach ($candidates as $candidate) {
                    // if (($maxLen > 0) and (strlen($candidate) >= $maxLen)) {
                    //     continue;
                    // }
                    foreach (array_keys($subNodeGenerates) as $segment) {
                        $newCandidate = $candidate . $segment;
                        if (!isset($newCandidates[$newCandidate])) {
                            $newCandidates[$newCandidate] = true;
                        }
                    }
                }
                $candidates = array_keys($newCandidates);
            }
            foreach ($candidates as $candidate) {
                $this->generates[$idxNode][$candidate] = true;
            }
        }
        return $this->generates[$idxNode];
    }

    /** @param string[] $input */
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
    /** @var array<int[]> */
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
        $this->match = '';
        $b = explode(' | ', $a[1]);
        foreach ($b as $list) {
            $this->subNodes[] = array_map('intval', explode(' ', $list));
        }
    }
}

<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2021;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2021 Day 18: Snailfish.
 *
 * Part 1: What is the magnitude of the final sum?
 * Part 2: What is the largest magnitude of any sum of two different snailfish numbers from the homework assignment?
 *
 * @topic: binary tree
 *
 * @see https://adventofcode.com/2021/day/18
 */
final class Aoc2021Day18 extends SolutionBase
{
    public const YEAR = 2021;
    public const DAY = 18;
    public const TITLE = 'Snailfish';
    public const SOLUTIONS = [4008, 4667];
    public const EXAMPLE_SOLUTIONS = [[4140, 3993]];

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
        if (count($input) < 2) {
            throw new \Exception('Invalid input');
        }
        $snailfishes = array_map(
            static fn (string $s): Snailfish => Snailfish::fromString($s),
            $input,
        );
        // Snailfish::unitTest();
        // ---------- Part 1
        $sum = $snailfishes[0];
        for ($i = 1; $i < count($input); ++$i) {
            $sum = Snailfish::add($sum, $snailfishes[$i]);
        }
        $ans1 = $sum->magnitude();
        // ---------- Part 2
        $ans2 = 0;
        foreach ($snailfishes as $id1 => $sf1) {
            foreach ($snailfishes as $id2 => $sf2) {
                if ($id1 == $id2) {
                    continue;
                }
                $magni = Snailfish::add($sf1, $sf2)->magnitude();
                if ($magni > $ans2) {
                    $ans2 = $magni;
                }
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}

// --------------------------------------------------------------------
final class Snailfish
{
    public const DEBUG = false;
    public const MAX_DEPTH = 4;
    public const MAX_VALUE = 10;

    public bool $isRegular = true;
    public int $value = 0;
    public ?Snailfish $parent = null;
    public ?Snailfish $left = null;
    public ?Snailfish $right = null;

    public function __clone()
    {
        if (!is_null($this->left)) {
            $this->left = clone $this->left;
            $this->left->parent = $this;
        }
        if (!is_null($this->right)) {
            $this->right = clone $this->right;
            $this->right->parent = $this;
        }
    }

    public function toRegular(int $value = 0): void
    {
        $this->isRegular = true;
        $this->value = $value;
        $this->left = null;
        $this->right = null;
    }

    /**
     * @codeCoverageIgnore
     */
    public function toString(): string
    {
        if ($this->isRegular) {
            return strval($this->value);
        }
        return '[' . $this->left?->toString() . ',' . $this->right?->toString() . ']';
    }

    /**
     * @codeCoverageIgnore
     */
    public function logSelf(string $route = ''): void
    {
        echo $route . ' : ' . ($this->isRegular ? $this->value : 'pair'), PHP_EOL;
        if ((strlen($route) == 0) and !is_null($this->parent)) {
            echo 'ERROR: parent found at depth == 0', PHP_EOL;
        }
        if ((strlen($route) != 0) and is_null($this->parent)) {
            echo 'ERROR: no parent found at depth > 0', PHP_EOL;
        }
        if ($this->isRegular and (isset($this->left) or isset($this->left))) {
            echo 'ERROR: child node found for a regular node', PHP_EOL;
        }
        if ($this->isRegular) {
            return;
        }
        if (!isset($this->left) or !isset($this->left)) {
            echo 'ERROR: missing child node for a pair node', PHP_EOL;
        }
        $this->left?->logSelf($route . '-L');
        $this->right?->logSelf($route . '-R');
    }

    public function magnitude(): int
    {
        if ($this->isRegular) {
            return $this->value;
        }
        return 3 * $this->left?->magnitude() + 2 * $this->right?->magnitude();
    }

    public function findNodeToExplode(int $depth = 0): self|false
    {
        if ($this->isRegular) {
            return false;
        }
        if ($depth == self::MAX_DEPTH) {
            return $this;
        }
        if (is_null($this->left)) {
            // @codeCoverageIgnoreStart
            return false;
            // @codeCoverageIgnoreEnd
        }
        $result = $this->left->findNodeToExplode($depth + 1);
        if ($result !== false) {
            return $result;
        }
        if (is_null($this->right)) {
            // @codeCoverageIgnoreStart
            return false;
            // @codeCoverageIgnoreEnd
        }
        return $this->right->findNodeToExplode($depth + 1);
    }

    public function explode(): bool
    {
        $node = $this->findNodeToExplode();
        if ($node === false) {
            return false;
        }
        if ($node->isRegular or !$node->left?->isRegular or !$node->right?->isRegular) {
            // @codeCoverageIgnoreStart
            throw new \Exception('Impossible');
            // @codeCoverageIgnoreEnd
        }
        // @phpstan-ignore-next-line
        if (self::DEBUG) {
            // @codeCoverageIgnoreStart
            echo '-- exploding node: ' . $node->toString(), PHP_EOL;
            // @codeCoverageIgnoreEnd
        }
        $leftValue = $node->left->value;
        $rightValue = $node->right->value;
        $leftRegularNode = null;
        $rightRegularNode = null;
        $isNodePassed = false;
        // (ineffectively) find previous and next regular nodes
        $stack = [];
        $current = $this;
        $isNodePassed = false;
        while ((count($stack) != 0) or !is_null($current)) {
            if (!is_null($current)) {
                $stack[] = $current;
                $current = $current->left;
            } else {
                $current = array_pop($stack);
                if ($current === $node) {
                    $isNodePassed = true;
                }
                if ($current?->isRegular) {
                    if ($current->parent !== $node) {
                        if (!$isNodePassed) {
                            $leftRegularNode = $current;
                        } elseif (is_null($rightRegularNode)) {
                            $rightRegularNode = $current;
                        }
                    }
                }
                $current = $current?->right;
            }
        }
        if (!is_null($leftRegularNode)) {
            $leftRegularNode->value += $leftValue;
        }
        if (!is_null($rightRegularNode)) {
            $rightRegularNode->value += $rightValue;
        }
        $node->toRegular(0);
        return true;
    }

    public function split(): bool
    {
        if ($this->isRegular) {
            if ($this->value < self::MAX_VALUE) {
                return false;
            }
            // @phpstan-ignore-next-line
            if (self::DEBUG) {
                // @codeCoverageIgnoreStart
                echo '-- splitting node: ' . $this->toString(), PHP_EOL;
                // @codeCoverageIgnoreEnd
            }
            $leftValue = intdiv($this->value, 2);
            $rightValue = $this->value - $leftValue;
            $this->isRegular = false;
            $this->left = self::fromInt($leftValue);
            $this->left->parent = $this;
            $this->right = self::fromInt($rightValue);
            $this->right->parent = $this;
            return true;
        }
        $leftResult = $this->left?->split();
        if ($leftResult) {
            return true;
        }
        if (is_null($this->right)) {
            // @codeCoverageIgnoreStart
            return false;
            // @codeCoverageIgnoreEnd
        }
        return $this->right->split();
    }

    public function reduce(): self
    {
        while (true) {
            // @phpstan-ignore-next-line
            if (self::DEBUG) {
                // @codeCoverageIgnoreStart
                echo '-- trying to reduce ' . $this->toString(), PHP_EOL;
                // @codeCoverageIgnoreEnd
            }
            $result = $this->explode();
            if ($result) {
                continue;
            }
            $result = $this->split();
            if (!$result) {
                break;
            }
        }
        return $this;
    }

    public static function fromInt(int $value): self
    {
        $sf = new self();
        $sf->isRegular = true;
        $sf->value = $value;
        return $sf;
    }

    public static function fromPair(self $left, self $right): self
    {
        $sf = new self();
        $sf->isRegular = false;
        $sf->left = $left;
        $sf->left->parent = $sf;
        $sf->right = $right;
        $sf->right->parent = $sf;
        return $sf;
    }

    public static function fromString(string $s): self
    {
        if (strlen($s) == 0) {
            throw new \Exception('Invalid input');
        }
        if ($s[0] != '[') {
            return self::fromInt(intval($s));
        }
        $depth = 0;
        $i = 0;
        while ($i < strlen($s) - 1) {
            ++$i;
            if ($s[$i] == '[') {
                ++$depth;
                continue;
            }
            if ($s[$i] == ']') {
                --$depth;
                continue;
            }
            if (($s[$i] == ',') and ($depth == 0)) {
                break;
            }
        }
        if ($i == strlen($s)) {
            throw new \Exception('Invalid input');
        }
        $left = self::fromString(substr($s, 1, $i - 1));
        $right = self::fromString(substr($s, $i + 1, -1));
        return self::fromPair($left, $right);
    }

    public static function add(self $a, self $b): self
    {
        $left = clone $a;
        $right = clone $b;
        $result = self::fromPair($left, $right);
        $result->reduce();
        return $result;
    }

    /**
     * @codeCoverageIgnore
     */
    private function unitTest(): void
    {
        assert(Snailfish::fromString('[[[[[9,8],1],2],3],4]')->reduce()->toString() === '[[[[0,9],2],3],4]');
        assert(Snailfish::fromString('[7,[6,[5,[4,[3,2]]]]]')->reduce()->toString() === '[7,[6,[5,[7,0]]]]');
        assert(Snailfish::fromString('[[6,[5,[4,[3,2]]]],1]')->reduce()->toString() === '[[6,[5,[7,0]]],3]');
        assert(Snailfish::fromString('[[3,[2,[1,[7,3]]]],[6,[5,[4,[3,2]]]]]')->reduce()->toString()
            === '[[3,[2,[8,0]]],[9,[5,[7,0]]]]');
        assert(Snailfish::fromString('[[[[[4,3],4],4],[7,[[8,4],9]]],[1,1]]')->reduce()->toString()
            === '[[[[0,7],4],[[7,8],[6,0]]],[8,1]]');
        assert(Snailfish::fromString('[[9,1],[1,9]]')->magnitude() === 129);
        assert(Snailfish::fromString('[[[[0,7],4],[[7,8],[6,0]]],[8,1]]')->magnitude() === 1384);
        assert(Snailfish::fromString('[[[[1,1],[2,2]],[3,3]],[4,4]]')->magnitude() === 445);
        assert(Snailfish::fromString('[[[[3,0],[5,3]],[4,4]],[5,5]]')->magnitude() === 791);
        assert(Snailfish::fromString('[[[[5,0],[7,4]],[5,5]],[6,6]]')->magnitude() === 1137);
        assert(Snailfish::fromString('[[[[8,7],[7,7]],[[8,6],[7,7]]],[[[0,7],[6,6]],[8,7]]]')->magnitude() === 3488);
        assert(Snailfish::add(
            Snailfish::fromString('[[[0,[4,5]],[0,0]],[[[4,5],[2,6]],[9,5]]]'),
            Snailfish::fromString('[7,[[[3,7],[4,3]],[[6,3],[8,8]]]]'),
        )->toString() === '[[[[4,0],[5,4]],[[7,7],[6,0]]],[[8,[7,7]],[[7,9],[5,0]]]]');
        assert(Snailfish::add(
            Snailfish::fromString('[[[[4,0],[5,4]],[[7,7],[6,0]]],[[8,[7,7]],[[7,9],[5,0]]]]'),
            Snailfish::fromString('[[2,[[0,8],[3,4]]],[[[6,7],1],[7,[1,6]]]]'),
        )->toString() === '[[[[6,7],[6,7]],[[7,7],[0,7]]],[[[8,7],[7,7]],[[8,8],[8,0]]]]');
    }
}

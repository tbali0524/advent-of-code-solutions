<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2019;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2019 Day 22: Slam Shuffle.
 *
 * Part 1: After shuffling your factory order deck of 10007 cards, what is the position of card 2019?
 * Part 2: After shuffling your new, giant, factory order deck that many times,
 *         what number is on the card that ends up in position 2020?
 *
 * Topic: card deck simulation
 *
 * @see https://adventofcode.com/2019/day/22
 *
 * @todo complete part2
 */
final class Aoc2019Day22 extends SolutionBase
{
    public const YEAR = 2019;
    public const DAY = 22;
    public const TITLE = 'Slam Shuffle';
    public const SOLUTIONS = [8502, 0];
    public const EXAMPLE_SOLUTIONS = [[369258147, 0], [3074185296, 0], [6307418529, 0], [9258147036, 0]];

    public const MAX_CARDS_EXAMPLES = 10;
    public const MAX_CARDS_PART1 = 10_007;
    public const MAX_CARDS_PART2 = 119315717514047;
    public const MAX_SHUFFLES_PART2 = 101741582076661;
    public const CARD_TO_SEARCH_PART1 = 2019;
    public const CARD_POSITION_PART2 = 2020;

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
        $ans1 = 0;
        $isExample = count($input) <= 10;
        $maxCards = $isExample ? self::MAX_CARDS_EXAMPLES : self::MAX_CARDS_PART1;
        $deck = new Deck($maxCards);
        foreach ($input as $line) {
            $deck->shuffle($line);
        }
        if ($isExample) {
            $ans1 = intval(implode('', $deck->cards));
        } else {
            $ans1 = intval(array_search(self::CARD_TO_SEARCH_PART1, $deck->cards, true));
        }
        // ---------- Part 2
        $ans2 = 0;
        return [strval($ans1), strval($ans2)];
    }
}

// --------------------------------------------------------------------
final class Deck
{
    /** @var array<int, int> */
    public array $cards;

    public function __construct(
        public readonly int $maxCards,
    ) {
        $this->cards = range(0, $this->maxCards - 1);
    }

    public function dealIntoNew(): void
    {
        $this->cards = array_reverse($this->cards);
    }

    public function cut(int $n): void
    {
        // works also for negative $n
        $this->cards = array_merge(array_slice($this->cards, $n), array_slice($this->cards, 0, $n));
    }

    public function dealWithIncrement(int $n): void
    {
        $newCards = array_fill(0, $this->maxCards, 0);
        $pos = 0;
        for ($i = 0; $i < $this->maxCards; ++$i) {
            $newCards[$pos] = $this->cards[$i];
            $pos = ($pos + $n) % $this->maxCards;
        }
        $this->cards = $newCards;
    }

    public function shuffle(string $command): void
    {
        if ($command == 'deal into new stack') {
            $this->dealIntoNew();
            return;
        }
        if (str_starts_with($command, 'deal with increment ')) {
            $n = intval(substr($command, 20));
            $this->dealWithIncrement($n);
            return;
        }
        if (str_starts_with($command, 'cut ')) {
            $n = intval(substr($command, 4));
            $this->cut($n);
            return;
        }
        throw new \Exception('Invalid input');
    }

    /**
     * @codeCoverageIgnore
     */
    public function printDeck(): void
    {
        echo implode(' ', $this->cards), PHP_EOL;
    }
}

<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2023;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2023 Day 7: Camel Cards.
 *
 * Part 1: Find the rank of every hand in your set. What are the total winnings?
 * Part 2: Using the new joker rule, find the rank of every hand in your set. What are the new total winnings?
 *
 * Topics: Poker hands
 *
 * @see https://adventofcode.com/2023/day/7
 */
final class Aoc2023Day07 extends SolutionBase
{
    public const YEAR = 2023;
    public const DAY = 7;
    public const TITLE = 'Camel Cards';
    public const SOLUTIONS = [251121738, 251421071];
    public const EXAMPLE_SOLUTIONS = [[6440, 5905]];

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
        $hands = [];
        foreach ($input as $line) {
            $a = explode(' ', $line);
            if (count($a) != 2) {
                throw new \Exception('Invalid input');
            }
            $hands[] = new CamelHand($a[0], intval($a[1]));
        }
        // ---------- Part 1
        $ans1 = 0;
        usort($hands, CamelHand::compare(...));
        foreach ($hands as $idx => $hand) {
            $ans1 += ($idx + 1) * $hand->bid;
        }
        // ---------- Part 2
        $ans2 = 0;
        $jokerHands = array_map(
            static fn (CamelHand $hand): JokerHand => new JokerHand($hand),
            $hands,
        );
        usort($jokerHands, JokerHand::compare(...));
        foreach ($jokerHands as $idx => $hand) {
            $ans2 += ($idx + 1) * $hand->bid;
        }
        return [strval($ans1), strval($ans2)];
    }
}

// --------------------------------------------------------------------
enum HandType: int
{
    case Five_of_a_kind = 6;
    case Four_of_a_kind = 5;
    case Full_house = 4;
    case Three_of_a_kind = 3;
    case Two_pair = 2;
    case One_pair = 1;
    case High_card = 0;
}

// --------------------------------------------------------------------
class CamelHand
{
    public const LABELS = '23456789TJQKA';
    public readonly HandType $type;
    private readonly int $strength;

    public function __construct(
        public readonly string $cards,
        public readonly int $bid,
    ) {
        if (strlen($cards) != 5) {
            throw new \Exception('Invalid input');
        }
        $cv = array_count_values(str_split($cards));
        arsort($cv);
        $first = $cv[array_key_first($cv)];
        $this->type = match (count($cv)) {
            1 => HandType::Five_of_a_kind,
            2 => ($first == 4 ? HandType::Four_of_a_kind : HandType::Full_house),
            3 => ($first == 3 ? HandType::Three_of_a_kind : HandType::Two_pair),
            4 => HandType::One_pair,
            5 => HandType::High_card,
            default => throw new \Exception('Impossible'),
        };
        $strength = $this->type->value;
        foreach (str_split($cards) as $card) {
            $p = strpos(self::LABELS, $card);
            if ($p === false) {
                throw new \Exception('Invalid input');
            }
            $strength = ($strength << 4) + $p;
        }
        $this->strength = $strength;
    }

    public static function compare(self $a, self $b): int
    {
        return $a->strength <=> $b->strength;
    }
}

// --------------------------------------------------------------------
class JokerHand
{
    public const LABELS = 'J23456789TQKA';
    public readonly string $cards;
    public readonly int $bid;
    public readonly HandType $type;
    private readonly int $strength;

    public function __construct(CamelHand $camelHand)
    {
        $this->cards = $camelHand->cards;
        $this->bid = $camelHand->bid;
        $bestType = HandType::High_card;
        for ($i = 0; $i < strlen(self::LABELS); ++$i) {
            $cards = str_replace('J', self::LABELS[$i], $this->cards);
            $hand = new CamelHand($cards, 0);
            if ($hand->type->value > $bestType->value) {
                $bestType = $hand->type;
            }
        }
        $this->type = $bestType;
        $strength = $this->type->value;
        foreach (str_split($this->cards) as $card) {
            $p = strpos(self::LABELS, $card);
            if ($p === false) {
                // @codeCoverageIgnoreStart
                throw new \Exception('Impossible');
                // @codeCoverageIgnoreEnd
            }
            $strength = ($strength << 4) + $p;
        }
        $this->strength = $strength;
    }

    public static function compare(self $a, self $b): int
    {
        return $a->strength <=> $b->strength;
    }
}

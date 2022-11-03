<?php

/*
https://adventofcode.com/2020/day/22
Part 1: Play the small crab in a game of Combat using the two decks you just dealt. What is the winning player's score?
Part 2: Defend your honor as Raft Captain by playing the small crab in a game of Recursive Combat
    using the same two decks as before. What is the winning player's score?
*/

// phpcs:disable PSR1.Classes.ClassDeclaration

declare(strict_types=1);

namespace TBali\Aoc2020;

use TBali\Aoc\SolutionBase;

final class Aoc2020Day22 extends SolutionBase
{
    public const YEAR = 2020;
    public const DAY = 22;
    public const TITLE = 'Crab Combat';
    public const SOLUTIONS = [34566, 0];
    public const EXAMPLE_SOLUTIONS = [[306, 291], [0, 0]];

    /**
     * @param string[] $input
     *
     * @return array{string, string}
     */
    public function solve(array $input): array
    {
        [$player1, $player2] = $this->parseInput($input);
        // ---------- Part 1
        while ($player1->isInGame() and $player2->isInGame()) {
            SpaceCardDeck::fight($player1, $player2);
        }
        $ans1 = max($player1->score(), $player2->score());
        // ---------- Part 2
        $ans2 = 0;
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param string[] $input
     *
     * @return SpaceCardDeck[]
     */
    private function parseInput(array $input): array
    {
        if (count($input) < 5) {
            throw new \Exception('Invalid input');
        }
        $ans = [];
        $idxLine = 0;
        while ($idxLine < count($input)) {
            $line = $input[$idxLine];
            if (!str_starts_with($line, 'Player ') or ($line[strlen($line) - 1] != ':') or (strlen($line) < 9)) {
                throw new \Exception('Invalid input');
            }
            $player = intval(substr($line, 7, strlen($line) - 8));
            ++$idxLine;
            $cards = [];
            while (($idxLine < count($input)) and ($input[$idxLine] != '')) {
                $cards[] = intval($input[$idxLine]);
                ++$idxLine;
            }
            $ans[] = new SpaceCardDeck($player, array_reverse($cards));
            while (($idxLine < count($input)) and ($input[$idxLine] == '')) {
                ++$idxLine;
            }
        }
        return $ans;
    }
}

// --------------------------------------------------------------------
final class SpaceCardDeck
{
    /** @var int[] $cards */
    public function __construct(
        public readonly int $id = 0,
        public array $cards = []
    ) {
    }

    public function score(): int
    {
        $ans = 0;
        foreach ($this->cards as $idx => $value) {
            $ans += ($idx + 1) * $value;
        }
        return $ans;
    }

    public function isInGame(): bool
    {
        return count($this->cards) > 0;
    }

    public static function fight(self $a, self $b): void
    {
        $aCard = array_pop($a->cards);
        $bCard = array_pop($b->cards);
        if ($aCard < $bCard) {
            array_unshift($b->cards, $bCard);
            array_unshift($b->cards, $aCard);
        } elseif ($aCard > $bCard) {
            array_unshift($a->cards, $aCard);
            array_unshift($a->cards, $bCard);
        } else {
            array_unshift($a->cards, $aCard);
            array_unshift($b->cards, $bCard);
        }
    }
}

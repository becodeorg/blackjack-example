<?php

declare(strict_types=1);

class Player
{
    /** @var Card[] */
    protected array $cards = [];
    protected bool $lost = false;

    protected CONST MAX_NUMBER = 21;

    public function __construct(Deck $deck)
    {
        $this->cards[] = $deck->drawCard();
        $this->cards[] = $deck->drawCard();

        $this->checkIfLost();
    }

    public function getScore(): int
    {
        $score = 0;
        foreach ($this->cards as $card) {
            $score += $card->getValue();
        }

        return $score;
    }

    public function hit(Deck $deck) : void
    {
        $this->cards[] = $deck->drawCard();
        $this->checkIfLost();
    }

    public function lose() : void
    {
        $this->lost = true;
    }

    public function hasLost() : bool
    {
        return $this->lost;
    }

    public function getCards(): array
    {
        return $this->cards;
    }

    private function checkIfLost() : void
    {
        $this->lost = ($this->getScore() > self::MAX_NUMBER);
    }
}
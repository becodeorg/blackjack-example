<?php


class Dealer extends Player
{
    private const DRAW_UNTIL = 15;

    public function __construct(Deck $deck)
    {
        $this->cards[] = $deck->drawCard();
        $this->cards[] = $deck->drawCard();
    }

    public function hit(Deck $deck) : void
    {
        while($this->getScore() < self::DRAW_UNTIL) {
            parent::hit($deck);
        }

        $this->lost = ($this->getScore() > self::MAX_NUMBER);
    }
}
?>

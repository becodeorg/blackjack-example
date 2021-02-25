<?php
declare(strict_types=1);

class Blackjack
{
    private CONST MAX_SCORE = 21;

    private Player $player;
    private Dealer $dealer;
    private Deck $deck;

    public function __construct()
    {
        $this->deck = new Deck();
        $this->deck->shuffle();

        $this->player = new Player($this->deck);
        $this->dealer = new Dealer($this->deck);
    }

    public function getPlayer(): Player
    {
        return $this->player;
    }

    public function getDealer(): Dealer
    {
        return $this->dealer;
    }

    public function getDeck(): Deck
    {
        return $this->deck;
    }

    public function determineWinner() :? string
    {
        if ($this->getPlayer()->hasLost()) {
            return 'Dealer';
        }

        if($this->getDealer()->hasLost()) {
            return 'Player';
        }

        return null;
    }

    public function standOff() : void {
        if($this->getDealer()->getScore() >= $this->getPlayer()->getScore()){
            $this->getPlayer()->lose();
            return;
        }

        $this->getDealer()->lose();
    }
}
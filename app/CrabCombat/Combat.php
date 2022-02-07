<?php
	namespace App\CrabCombat;

	class Combat
	{
		/** @var Deck[] */
		public array $decks = [];
		public ?int $winner;

		public function __construct(Deck $deck1, Deck $deck2)
		{
			$this->decks[1] = $deck1;
			$this->decks[2] = $deck2;
		}

		public function play(): void
		{
			while (count($this->decks[1]) > 0 && count($this->decks[2]) > 0)
			{
				$p1 = $this->decks[1]->play();
				$p2 = $this->decks[2]->play();

				if ($p1 > $p2)
				{
					$this->decks[1]->add([$p1, $p2]);
				}
				elseif ($p1 < $p2)
				{
					$this->decks[2]->add([$p2, $p1]);
				}
			}

			$this->winner = (count($this->decks[1]) === 0) ? 2 : 1;
		}

		public function score(int $player): int
		{
			return $this->decks[$player]->score();
		}

		public function winningScore(): int
		{
			return $this->score($this->winner);
		}
	}
?>

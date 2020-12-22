<?php
	namespace App\CrabCombat;

	use Bolt\Json;

	class RecursiveCombat extends Combat
	{
		public array $history = [];

		public function play(): void
		{
			while (count($this->decks[1]) > 0 && count($this->decks[2]) > 0)
			{
				if (in_array($this->hash(), $this->history))
				{
					$this->winner = 1;
					return;
				}

				$this->history[] = $this->hash();

				$p1 = $this->decks[1]->play();
				$p2 = $this->decks[2]->play();

				if (count($this->decks[1]) >= $p1 && count($this->decks[2]) >= $p2)
				{
					$game = new RecursiveCombat(
						new Deck(array_slice($this->decks[1]->cards, 0, $p1)),
						new Deck(array_slice($this->decks[2]->cards, 0, $p2))
					);
					$game->play();
					$winner = $game->winner;

					if ($winner === 1)
					{
						$this->decks[1]->add([$p1, $p2]);
					}
					elseif ($winner === 2)
					{
						$this->decks[2]->add([$p2, $p1]);
					}
				}
				else
				{
					if ($p1 > $p2)
					{
						$this->decks[1]->add([$p1, $p2]);
					}
					elseif ($p1 < $p2)
					{
						$this->decks[2]->add([$p2, $p1]);
					}
				}
			}

			$this->winner = (count($this->decks[1]) === 0) ? 2 : 1;
		}

		public function hash(): string
		{
			return md5(Json::encode([$this->decks[1]->cards, $this->decks[2]->cards]));
		}
	}
?>

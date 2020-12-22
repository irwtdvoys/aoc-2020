<?php
	namespace App\CrabCombat;

	use Countable;

	class Deck implements Countable
	{
		public array $cards = [];

		public function __construct(array $cards)
		{
			$this->cards = $cards;
		}

		public function play(): int
		{
			return array_shift($this->cards);
		}

		public function add(array $cards): void
		{
			$this->cards = array_merge($this->cards, $cards);
		}

		public function score(): int
		{
			$count = count($this->cards);
			$score = 0;

			for ($loop = 0; $loop < $count; $loop++)
			{
				$score += $this->cards[$loop] * ($count - $loop);
			}

			return $score;
		}

		public function count(): int
		{
			return count($this->cards);
		}
	}
?>

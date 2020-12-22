<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\CrabCombat\Combat;
	use App\CrabCombat\Deck;
	use App\CrabCombat\RecursiveCombat;

	class CrabCombat extends Helper
	{
		public array $decks = [];

		public function __construct(int $day, string $override = null)
		{
			parent::__construct($day);

			$decks = explode(str_repeat(PHP_EOL, 2), parent::load($override));

			foreach ($decks as $deck)
			{
				list($player, $data) = explode(":" . PHP_EOL, $deck);
				$this->decks[(int)substr($player, -1)] = new Deck(array_map("intval", explode(PHP_EOL, $data)));
			}
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			$game = new Combat($this->decks[1], $this->decks[2]);
			$game->play();
			$result->part1 = $game->winningScore();

			return $result;
		}
	}
?>

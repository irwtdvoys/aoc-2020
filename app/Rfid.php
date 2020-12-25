<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\Messages\Rule;

	class Rfid extends Helper
	{
		const DIVIDER = 20201227;

		public int $card;
		public int $door;

		public function __construct(int $day, string $override = null)
		{
			parent::__construct($day);

			$keys = explode(PHP_EOL, parent::load($override));
			$this->card = $keys[0];
			$this->door = $keys[1];
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			$cardLoop = 0;
			$cardValue = 1;

			do
			{
				$cardValue = $this->handshake($cardValue, 7, 1);
				$cardLoop++;
			}
			while ($cardValue !== $this->card);

			$result->part1 = $this->handshake(1, $this->door, $cardLoop);

			return $result;
		}

		private function handshake(int $value, int $subject, int $iterations): int
		{
			for ($loop = 0; $loop < $iterations; $loop++)
			{
				$value *= $subject;
				$value = $value % self::DIVIDER;
			}

			return $value;
		}
	}
?>

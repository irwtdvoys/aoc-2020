<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;

	class MemoryGame extends Helper
	{
		public array $input = [2, 0, 1, 9, 5, 19];
		public int $last;
		public array $history;

		public function __construct(int $day)
		{
			parent::__construct($day);

			$this->last = array_pop($this->input);
			$this->history = array_combine($this->input, range(1, count($this->input)));
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			$turn = count($this->input) + 1;

			while ($turn < 30000000)
			{
				if (!isset($this->history[$this->last]))
				{
					$this->history[$this->last] = $turn;
					$this->last = 0;
				}
				else
				{
					$previous = $this->history[$this->last];
					$this->history[$this->last] = $turn;
					$this->last = ($turn) - $previous;
				}

				$turn++;

				if ($turn === 2020)
				{
					$result->part1 = $this->last;
				}
			}

			$result->part2 = $this->last;

			return $result;
		}
	}
?>

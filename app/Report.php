<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;

	class Report extends Helper
	{
		/** @var int[] */
		public array $data;

		public function __construct(int $day, bool $verbose = false, string $override = null)
		{
			parent::__construct($day, $verbose);

			$this->data = array_map("intval", explode(PHP_EOL, parent::load($override)));
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			$count = count($this->data);

			for ($loop1 = 0; $loop1 < $count - 1; $loop1++)
			{
				for ($loop2 = $loop1 + 1; $loop2 < $count; $loop2++)
				{
					if ($this->data[$loop1] + $this->data[$loop2] === 2020)
					{
						$result->part1 = $this->data[$loop1] * $this->data[$loop2];
					}

					if ($loop2 !== $count - 1)
					{
						for ($loop3 = $loop2 + 1; $loop3 < $count; $loop3++)
						{
							if ($this->data[$loop1] + $this->data[$loop2] + $this->data[$loop3] === 2020)
							{
								$result->part2 = $this->data[$loop1] * $this->data[$loop2] * $this->data[$loop3];
							}
						}
					}
				}
			}

			return $result;
		}
	}
?>

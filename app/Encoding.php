<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\VirtualMachine\Instruction;

	class Encoding extends Helper
	{
		public array $data = [];
		public int $preamble = 25;

		public function __construct(int $day, bool $verbose = false, string $override = null)
		{
			parent::__construct($day, $verbose);

			$this->data = array_map("intval", explode(PHP_EOL, parent::load($override)));
		}

		public function sumExists(array $data, int $value): bool
		{
			for ($loop1 = 0; $loop1 < count($data) - 1; $loop1++)
			{
				for ($loop2 = $loop1 + 1; $loop2 < count($data); $loop2++)
				{
					if ($data[$loop1] + $data[$loop2] === $value)
					{
						return true;
					}
				}
			}

			return false;
		}

		public function isValid(int $index): bool
		{
			$slice = array_slice($this->data, $index - $this->preamble, $this->preamble);

			return $this->sumExists($slice, $this->data[$index]);
		}

		public function find(int $value): int
		{
			for ($index = 0; $index < count($this->data); $index++)
			{
				$accumulator = 0;
				$first = $index;

				for ($loop = $index; $loop < count($this->data); $loop++)
				{
					$accumulator += $this->data[$loop];

					if ($accumulator > $value)
					{
						break;
					}
					elseif ($accumulator === $value)
					{
						$last = $loop;
						break 2;
					}
				}
			}

			$range = array_slice($this->data, $first, $last - $first + 1);

			return min($range) + max($range);
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			for ($index = $this->preamble; $index < count($this->data); $index++)
			{
				if (!$this->isValid($index))
				{
					$result->part1 = $this->data[$index];
					$result->part2 = $this->find($result->part1);
					break;
				}
			}

			return $result;
		}
	}
?>

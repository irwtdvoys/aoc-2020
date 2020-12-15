<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\Bitmasking\Program;

	class Bitmasking extends Helper
	{
		public array $programs;
		public array $memory = [];
		public array $memory2 = [];

		public function __construct(int $day, string $override = null)
		{
			parent::__construct($day);

			$raw = parent::load($override);

			$this->programs = array_map(
				function($element)
				{
					return new Program(trim($element));
				},
				preg_split("/(?=mask)/", $raw, -1, PREG_SPLIT_NO_EMPTY)
			);
		}

		public function applyMask(string $mask, int $value): int
		{
			$length = strlen($mask);
			$binary = str_pad(decbin($value), $length, "0", STR_PAD_LEFT);

			for ($index = 0; $index < $length; $index++)
			{
				if ($mask[$index] !== "X")
				{
					$binary[$index] = $mask[$index];
				}
			}

			return bindec($binary);
		}

		public function applyMask2(string $mask, int $value): array
		{
			$length = strlen($mask);
			$binary = str_pad(decbin($value), $length, "0", STR_PAD_LEFT);

			for ($index = 0; $index < $length; $index++)
			{
				if ($mask[$index] !== "0")
				{
					$binary[$index] = $mask[$index];
				}
			}

			$masks = [
				$binary
			];

			for ($loop = 0; $loop < count($masks); $loop++)
			{
				$index = strpos($masks[$loop], "X");

				if ($index === false)
				{
					continue;
				}

				$tmp = $masks[$loop];
				$tmp[$index] = "0";
				$masks[] = $tmp;
				$tmp[$index] = "1";
				$masks[] = $tmp;

				$masks[$loop] = "";
			}

			$result = array_map(
				function($element)
				{
					return bindec($element);
				},
				array_filter($masks)
			);

			return $result;
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			foreach ($this->programs as $program)
			{
				foreach ($program->instructions as $instruction)
				{
					$this->memory[$instruction->location] = $this->applyMask($program->mask, $instruction->value);

					$locations = $this->applyMask2($program->mask, $instruction->location);

					foreach ($locations as $location)
					{
						$this->memory2[$location] = $instruction->value;
					}
				}
			}

			foreach ($this->memory as $memory)
			{
				if ($memory !== 0)
				{
					$result->part1 += $memory;
				}
			}

			foreach ($this->memory2 as $memory)
			{
				if ($memory !== 0)
				{
					$result->part2 += $memory;
				}
			}

			return $result;
		}
	}
?>

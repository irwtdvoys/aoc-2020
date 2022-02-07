<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;

	class Homework extends Helper
	{
		const ADDITION = "+";
		const MULTIPLICATION = "*";

		public array $data = [];
		public object $range;

		public function __construct(int $day, bool $verbose = false, string $override = null)
		{
			parent::__construct($day, $verbose);

			$this->data = explode(PHP_EOL, parent::load($override));
		}

		public function solve(string $sum, bool $advanced = false): int
		{
			if (strrpos($sum, "(") !== false)
			{
				$sum = $this->simplify($sum, $advanced);
			}

			$parts = array_map(
				function ($element)
				{
					return $element === self::ADDITION || $element === self::MULTIPLICATION ? $element : (int)$element;
				},
				explode(" ", $sum)
			);

			return ($advanced === false) ? $this->basic($parts) : $this->advanced($parts);
		}

		private function processOperation(array $parts, $operation): array
		{
			while (in_array($operation, $parts))
			{
				for ($index = 1; $index < count($parts) - 1; $index++)
				{
					if ($parts[$index] === $operation)
					{
						$result = $this->calculate($parts[$index - 1], $parts[$index], $parts[$index + 1]);

						$parts = array_merge(
							array_slice($parts, 0, $index - 1),
							[$result],
							array_slice($parts, $index + 2)
						);

						break;
					}
				}
			}

			return $parts;
		}

		private function basic(array $parts): int
		{
			while (count($parts) > 1)
			{
				$result = $this->calculate($parts[0], $parts[1], $parts[2]);

				$parts = array_merge(
					[$result],
					array_slice($parts, 3)
				);
			}

			return $parts[0];
		}

		private function advanced(array $parts): int
		{
			$parts = $this->processOperation($parts, self::ADDITION);
			$parts = $this->processOperation($parts, self::MULTIPLICATION);

			return $parts[0];
		}

		private function calculate(int $a, string $operation, int $b): int
		{
			switch ($operation)
			{
				case self::ADDITION:
					$result = $a + $b;
					break;
				case self::MULTIPLICATION:
					$result = $a * $b;
					break;
				default:
					$result = 0;
					break;
			}

			return $result;
		}

		private function simplify(string $sum, bool $advanced = false): string
		{
			while (strrpos($sum, "(") !== false)
			{
				$from = strrpos($sum, "(");
				$to = strpos($sum, ")", $from);

				$sub = substr($sum, $from + 1, ($to - $from - 1));

				$answer = $this->solve($sub, $advanced);

				$sum = substr($sum, 0, $from) . (string)$answer . substr($sum, $to + 1);
			}

			return $sum;
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			foreach ($this->data as $sum)
			{
				$result->part1 += $this->solve($sum, false);
				$result->part2 += $this->solve($sum, true);
			}

			return $result;
		}
	}
?>

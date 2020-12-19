<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\Messages\Rule;

	class Messages extends Helper
	{
		public array $rules = [];
		public string $messages;
		public bool $override = false;

		public function __construct(int $day, string $override = null)
		{
			parent::__construct($day);

			$raw = parent::load($override);

			list($rules, $messages) = explode(PHP_EOL . PHP_EOL, $raw);

			$this->messages = $messages;

			array_map(
				function ($element)
				{
					list($index, $data) = explode(": ", $element);

					$this->rules[$index] = preg_match("/^\".+\"$/", $data) ? substr($data, 1, -1) : new Rule($data);

					return $element;
				},
				explode(PHP_EOL, $rules)
			);
		}

		public function generatePattern(int $index)
		{
			$rule = $this->rules[$index];

			if (!$rule instanceof Rule)
			{
				return $rule;
			}

			if ($rule->generated)
			{
				return $rule->generated;
			}

			$results = [];

			foreach ($rule->options as $option)
			{
				$calculated = "";

				foreach ($option as $value)
				{
					$calculated .= $this->generatePattern($value);
				}

				$results[] = $calculated;
			}

			$result = (count($results) === 1) ? $results[0] : "(" . implode("|", $results) . ")";

			if ($this->override === true)
			{
				if ($index === 8)
				{
					$result = "($result)+";
				}

				if ($index === 11)
				{
					$a = $this->generatePattern(42);
					$b = $this->generatePattern(31);

					$result = "($a$b|$a{2}$b{2}|$a{3}$b{3}|$a{4}$b{4}|$a{5}$b{5})";
				}
			}

			$this->rules[$index]->generated = $result;

			return $result;
		}

		private function reset(): void
		{
			foreach ($this->rules as $rule)
			{
				if ($rule instanceof Rule)
				{
					$rule->generated = null;
				}
			}
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			$result->part1 = preg_match_all("/^" . $this->generatePattern(0) . "$/m", $this->messages);

			$this->reset();
			$this->override = true;
			$result->part2 = preg_match_all("/^" . $this->generatePattern(0) . "$/m", $this->messages);

			return $result;
		}
	}
?>

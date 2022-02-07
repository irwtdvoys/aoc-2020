<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\Luggage\Bag;

	class Luggage extends Helper
	{
		public array $rules;

		public function __construct(int $day, bool $verbose = false, string $override = null)
		{
			parent::__construct($day, $verbose);

			$raw = parent::load($override);

			preg_match_all("/(?'bag'[a-z ]+) bags contain (?'contains'(,? ?\d [a-z ]+)+|(no other bags)).?/", $raw, $matches);

			$this->rules = [];

			for ($index = 0; $index < count($matches['bag']); $index++)
			{
				$this->rules[$matches['bag'][$index]] = new Bag(["name" => $matches['bag'][$index]]);
			}

			for ($index = 0; $index < count($matches['bag']); $index++)
			{
				preg_match_all("/(?'quantity'[\d]) (?'bag'[a-z ]+)+ bags?/", $matches['contains'][$index], $containsMatches);

				for ($bagLoop = 0; $bagLoop < count($containsMatches['bag']); $bagLoop++)
				{
					$this->rules[$matches['bag'][$index]]->children[] = [
						"quantity" => $containsMatches['quantity'][$bagLoop],
						"bag" => &$this->rules[$containsMatches['bag'][$bagLoop]]
					];
				}
			}
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			foreach ($this->rules as $bag)
			{
				if ($bag->name === "shiny gold")
				{
					continue;
				}

				$contains = $bag->contains();

				if (in_array("shiny gold", $contains))
				{
					$result->part1++;
				}

				$result->part2 = $this->rules["shiny gold"]->count() - 1;
			}

			return $result;
		}
	}
?>

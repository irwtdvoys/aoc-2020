<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\PassportProcessing\Passport;
	use Bolt\Base;
	use Bolt\Curl;

	class Bag extends Base
	{
		public string $name = "";
		public array $children = [];

		public function contains()
		{
			$bags = [$this->name];

			if (count($this->children) > 0)
			{
				foreach ($this->children as $child)
				{
					$bags = array_merge($bags, $child['bag']->contains());
				}
			}

			return array_unique($bags);
		}

		public function count()
		{
			$count = 1;

			if (count($this->children) > 0)
			{
				foreach ($this->children as $child)
				{
					echo($child['bag']->name . " x" . $child['quantity'] . PHP_EOL);
					$count += $child['quantity'] * $child['bag']->count();
				}
			}

			return $count;
		}
	}

	class Luggage extends Helper
	{
		public array $rules;

		public function __construct(int $day, string $override = null)
		{
			parent::__construct($day);

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

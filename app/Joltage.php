<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\Luggage\Bag as Node;

	class Joltage extends Helper
	{
		public array $data = [];

		public function __construct(int $day, string $override = null)
		{
			parent::__construct($day);

			$this->data = array_map("intval", explode(PHP_EOL, parent::load($override)));
		}

		public function run(): Result
		{
			$result = new Result(0, 0);


			$data = $this->data;
			$max = max($data) + 3;

			$data[] = 0;
			$data[] = $max;

			sort($data);

			$jumps = [];

			for ($index = 0; $index < count($data) - 1; $index++)
			{
				$difference = $data[$index + 1] - $data[$index];

				$jumps[$difference] = isset($jumps[$difference]) ? $jumps[$difference] + 1 : 1;
			}

			$result->part1 = $jumps[1] * $jumps[3];

			$tree = [];

			foreach ($data as $datum)
			{
				$name = (string)$datum;

				$tree[$name] = new Node(["name" => $name]);
			}

			foreach ($data as $datum)
			{
				$valid = array_filter(
					$data,
					function($element) use ($datum)
					{
						return $element > $datum && $element <= $datum + 3;
					}
				);

				foreach ($valid as $item)
				{
					$tree[(string)$datum]->children[] = &$tree[(string)$item];
				}
			}

			$counts = ["0" => 1];

			foreach ($tree as $nodeName => $children)
			{
				if (is_array($children) && count($children) > 0)
				{
					foreach ($children as $childName => $child)
					{
						$counts[$childName] = isset($counts[$childName]) ? $counts[$childName] + $counts[$nodeName] : $counts[$nodeName];
					}
				}
			}

			$result->part2 = $counts[$max];

			return $result;
		}
	}
?>

<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\Luggage\Bag as Node;

	class Seating extends Helper
	{
		const TILE_EMPTY = "L";
		const TILE_OCCUPIED = "#";
		const TILE_FLOOR = ".";

		public array $data = [];

		public function __construct(int $day, bool $verbose = false, string $override = null)
		{
			parent::__construct($day, $verbose);

			$this->data = array_map(
				function($element)
				{
					return str_split($element);
				},
				explode(PHP_EOL, parent::load($override))
			);
		}

		public function draw(): void
		{
			foreach ($this->data as $row)
			{
				echo(implode("", $row) . PHP_EOL);
			}

			echo(PHP_EOL);
		}

		public function count(): int
		{
			$count = 0;

			for ($x = 0; $x < count($this->data[0]); $x++)
			{
				for ($y = 0; $y < count($this->data); $y++)
				{
					if ($this->data[$y][$x] === self::TILE_OCCUPIED)
					{
						$count++;
					}
				}
			}

			return $count;
		}

		public function fetch(int $x, int $y, string $direction): int
		{
			switch ($direction)
			{
				case "N":
					$dx = 0;
					$dy = -1;
					break;
				case "NE":
					$dx = 1;
					$dy = -1;
					break;
				case "E":
					$dx = 1;
					$dy = 0;
					break;
				case "SE":
					$dx = 1;
					$dy = 1;
					break;
				case "S":
					$dx = 0;
					$dy = 1;
					break;
				case "SW":
					$dx = -1;
					$dy = 1;
					break;
				case "W":
					$dx = -1;
					$dy = 0;
					break;
				case "NW":
					$dx = -1;
					$dy = -1;
					break;
			}

			for ($distance = 1; $distance < count($this->data); $distance++)
			{
				$newX = $x + ($dx * $distance);
				$newY = $y + ($dy * $distance);

				if (!isset($this->data[$newY][$newX]))
				{
					break;
				}

				switch ($this->data[$newY][$newX])
				{
					case self::TILE_OCCUPIED:
						return 1;
					case self::TILE_EMPTY:
						return 0;
					case self::TILE_FLOOR:
						continue 2;
				}
			}

			return 0;
		}

		public function visible(int $x, int $y): int
		{
			$count = 0;

			$directions = ["N", "NE", "E", "SE", "S", "SW", "W", "NW"];

			foreach ($directions as $direction)
			{
				$count += $this->fetch($x, $y, $direction);
			}

			return $count;
		}

		public function adjacency(int $x, int $y): int
		{
			$count = 0;

			for ($xLoop = max($x - 1, 0); $xLoop <= min($x + 1, count($this->data[0]) - 1); $xLoop++)
			{
				for ($yLoop = max($y - 1, 0); $yLoop <= min($y + 1, count($this->data) - 1); $yLoop++)
				{
					if ($xLoop === $x && $yLoop === $y)
					{
						continue;
					}

					if ($this->data[$yLoop][$xLoop] === self::TILE_OCCUPIED)
					{
						$count++;
					}
				}
			}

			return $count;
		}

		public function step(int $part = 1): int
		{
			$state = $this->data;
			$changes = 0;

			for ($x = 0; $x < count($this->data[0]); $x++)
			{
				for ($y = 0; $y < count($this->data); $y++)
				{
					switch ($part)
					{
						case 2:
							$method = "visible";
							$number = 5;
							break;
						case 1:
						default:
							$method = "adjacency";
							$number = 4;
							break;
					}

					switch ($this->data[$y][$x])
					{
						case self::TILE_EMPTY:
							if ($this->$method($x, $y) === 0)
							{
								$state[$y][$x] = self::TILE_OCCUPIED;
								$changes++;
							}
							break;
						case self::TILE_OCCUPIED:
							if ($this->$method($x, $y) >= $number)
							{
								$state[$y][$x] = self::TILE_EMPTY;
								$changes++;
							}
							break;
					}
				}
			}

			$this->data = $state;

			return $changes;
		}

		public function run(): Result
		{
			$initialState = $this->data;
			$result = new Result(0, 0);

			$changes = PHP_INT_MAX;

			while ($changes !== 0)
			{
				$changes = $this->step();
				$this->draw();
			}

			$result->part1 = $this->count();

			$this->data = $initialState;

			$changes = PHP_INT_MAX;

			while ($changes !== 0)
			{
				$changes = $this->step(2);
				$this->draw();
			}

			$result->part2 = $this->count();

			return $result;
		}
	}
?>

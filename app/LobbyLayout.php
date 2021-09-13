<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\LobbyLayout\Instruction;
	use App\Utils\Position3d;
	use App\Utils\Range;

	class LobbyLayout extends Helper
	{
		const DIRECTION_EAST = "e";
		const DIRECTION_SOUTH_EAST = "se";
		const DIRECTION_SOUTH_WEST = "sw";
		const DIRECTION_WEST = "w";
		const DIRECTION_NORTH_WEST = "nw";
		const DIRECTION_NORTH_EAST = "ne";

		const TILE_WHITE = false;
		const TILE_BLACK = true;

		public array $instructions = [];
		public Position3d $position;
		public array $tiles = [];

		public function __construct(int $day, string $override = null)
		{
			parent::__construct($day);

			$this->instructions = array_map(
				function ($element)
				{
					return new Instruction($element);
				},
				explode(PHP_EOL, parent::load($override))
			);

			$this->position = new Position3d();
		}

		public function move(string $direction): void
		{
			switch ($direction)
			{
				case self::DIRECTION_EAST:
					$this->position->x++;
					$this->position->y--;
					break;
				case self::DIRECTION_SOUTH_EAST:
					$this->position->y--;
					$this->position->z++;
					break;
				case self::DIRECTION_SOUTH_WEST:
					$this->position->x--;
					$this->position->z++;
					break;
				case self::DIRECTION_WEST:
					$this->position->x--;
					$this->position->y++;
					break;
				case self::DIRECTION_NORTH_WEST:
					$this->position->y++;
					$this->position->z--;
					break;
				case self::DIRECTION_NORTH_EAST:
					$this->position->x++;
					$this->position->z--;
					break;
			}
		}

		public function count()
		{
			return count(array_filter($this->tiles));
		}

		public function neighbours(Position3d $position): int
		{
			$count = 0;

			$checks = [
				[1, -1, 0],
				[0, -1, 1],
				[-1, 0, 1],
				[-1, 1, 0],
				[0, 1, -1],
				[1, 0, -1]
			];

			foreach ($checks as $check)
			{
				$next = new Position3d(
					$position->x + $check[0],
					$position->y + $check[1],
					$position->z + $check[2]
				);

				$id = (string)$next;

				if (isset($this->tiles[$id]) && $this->tiles[$id] === self::TILE_BLACK)
				{
					$count++;
				}
			}

			return $count;
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			foreach ($this->instructions as $instruction)
			{
				$this->position->x = 0;
				$this->position->y = 0;
				$this->position->z = 0;

				foreach ($instruction->steps as $step)
				{
					$this->move($step);
				}

				$id = (string)$this->position;
				$this->tiles[$id] = isset($this->tiles[$id]) ? !$this->tiles[$id] : self::TILE_BLACK;
			}

			$result->part1 = $this->count();

			$day = 1;

			while ($day <= 100)
			{
				$state = $this->tiles;

				$tiles = array_filter($this->tiles);

				$range = (object)[
					"x" => new Range(0, 0),
					"y" => new Range(0, 0),
					"z" => new Range(0, 0)
				];

				foreach ($tiles as $key => $value)
				{
					list($x, $y, $z) = explode(",", $key);

					$range->x->add($x);
					$range->y->add($y);
					$range->z->add($z);
				}

				for ($x = $range->x->min - 1; $x <= $range->x->max + 1; $x++)
				{
					for ($y = $range->y->min - 1; $y <= $range->y->max + 1; $y++)
					{
						for ($z = $range->z->min - 1; $z <= $range->z->max + 1; $z++)
						{
							if ($x + $y + $z !== 0)
							{
								continue;
							}

							$current = new Position3d($x, $y, $z);

							$count = $this->neighbours($current);

							$currentValue = $this->tiles[(string)$current] ?? self::TILE_WHITE;

							switch ($currentValue)
							{
								case self::TILE_BLACK:
									if ($count === 0 || $count > 2)
									{
										$state[(string)$current] = self::TILE_WHITE;
									}
									break;
								case self::TILE_WHITE:
									if ($count === 2)
									{
										$state[(string)$current] = self::TILE_BLACK;
									}
									break;
							}
						}
					}
				}

				$this->tiles = $state;

				$day++;
			}

			$result->part2 = $this->count();

			return $result;
		}
	}
?>

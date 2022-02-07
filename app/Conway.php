<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\Conway\Tiles;
	use App\Utils\Position4d;
	use App\Utils\Range;

	class Conway extends Helper
	{
		public array $data = [];
		public object $range;

		public function __construct(int $day, bool $verbose = false, string $override = null)
		{
			parent::__construct($day, $verbose);

			$raw = parent::load($override);

			$rows = explode(PHP_EOL, $raw);

			for ($y = 0; $y < count($rows); $y++)
			{
				$elements = str_split($rows[$y]);

				for ($x = 0; $x < count($elements); $x++)
				{
					$position = new Position4d($x, $y, 0, 0);

					$this->data[(string)$position] = $elements[$x];
				}
			}
		}

		public function getState(Position4d $position): string
		{
			return isset($this->data[(string)$position]) ? $this->data[(string)$position] : Tiles::INACTIVE;
		}

		public function countNeighbors(Position4d $position): int
		{
			$count = 0;

			for ($x = -1; $x <= 1; $x++)
			{
				for ($y = -1; $y <= 1; $y++)
				{
					for ($z = -1; $z <= 1; $z++)
					{
						for ($w = -1; $w <= 1; $w++)
						{
							if ($x === 0 && $y === 0 && $z === 0 && $w === 0)
							{
								continue;
							}

							$current = new Position4d(
								$position->x + $x,
								$position->y + $y,
								$position->z + $z,
								$position->w + $w,
							);

							if ($this->getState($current) === Tiles::ACTIVE)
							{
								$count++;
							}
						}
					}
				}
			}

			return $count;
		}

		public function range()
		{
			$active = array_keys(array_filter(
				$this->data,
				function($element)
				{
					return $element === Tiles::ACTIVE;
				}
			));

			$xMin = $xMax = $yMin = $yMax = $zMin = $zMax = $wMin = $wMax = 0;

			foreach ($active as $next)
			{
				list($x, $y, $z, $w) = explode(",", $next);

				$xMin = min($xMin, $x);
				$xMax = max($xMax, $x);
				$yMin = min($yMin, $y);
				$yMax = max($yMax, $y);
				$zMin = min($zMin, $z);
				$zMax = max($zMax, $z);
				$wMin = min($wMin, $w);
				$wMax = max($wMax, $w);
			}

			return (object)[
				"x" => new Range($xMin - 1, $xMax + 1),
				"y" => new Range($yMin - 1, $yMax + 1),
				"z" => new Range($zMin - 1, $zMax + 1),
				"w" => new Range($wMin - 1, $wMax + 1)
			];
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			$initialData = $this->data;

			$cycle = 0;

			while ($cycle < 6)
			{
				$range = $this->range();
				$newData = $this->data;

				for ($x = $range->x->min; $x <= $range->x->max; $x++)
				{
					for ($y = $range->y->min; $y <= $range->y->max; $y++)
					{
						for ($z = $range->z->min; $z <= $range->z->max; $z++)
						{
							$current = new Position4d($x, $y, $z);

							$state = $this->getState($current);
							$neighbors = $this->countNeighbors($current);

							if ($state === Tiles::ACTIVE && $neighbors !== 2 && $neighbors !== 3)
							{
								$newData[(string)$current] = Tiles::INACTIVE;
							}
							elseif ($state === Tiles::INACTIVE && $neighbors === 3)
							{
								$newData[(string)$current] = Tiles::ACTIVE;
							}
						}
					}
				}

				$this->data = $newData;

				$cycle++;
			}

			$result->part1 = $this->countActive();

			$this->data = $initialData;

			$cycle = 0;

			while ($cycle < 6)
			{
				$range = $this->range();
				$newData = $this->data;

				for ($x = $range->x->min; $x <= $range->x->max; $x++)
				{
					for ($y = $range->y->min; $y <= $range->y->max; $y++)
					{
						for ($z = $range->z->min; $z <= $range->z->max; $z++)
						{
							for ($w = $range->w->min; $w <= $range->w->max; $w++)
							{
								$current = new Position4d($x, $y, $z, $w);

								$state = $this->getState($current);
								$neighbors = $this->countNeighbors($current);

								if ($state === Tiles::ACTIVE && $neighbors !== 2 && $neighbors !== 3)
								{
									$newData[(string)$current] = Tiles::INACTIVE;
								}
								elseif ($state === Tiles::INACTIVE && $neighbors === 3)
								{
									$newData[(string)$current] = Tiles::ACTIVE;
								}
							}
						}
					}
				}

				$this->data = $newData;

				$cycle++;
			}

			$result->part2 = $this->countActive();

			return $result;
		}

		public function countActive(): int
		{
			return count(array_filter(
				$this->data,
				function($element)
				{
					return $element === Tiles::ACTIVE;
				}
			));
		}
	}
?>

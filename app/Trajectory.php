<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\PasswordPolicy\Password;
	use AoC\Utils\Position2d;

	class Trajectory extends Helper
	{
		public array $map;
		public Position2d $position;
		public int $width;
		public int $height;

		public function __construct(int $day, bool $verbose = false, string $override = null)
		{
			parent::__construct($day, $verbose);

			$this->map = array_map(
				function($element)
				{
					return str_split($element);
				},
				explode(PHP_EOL, parent::load($override))
			);

			$this->height = count($this->map);
			$this->width = count($this->map[0]);
			$this->reset();
		}

		public function output(): void
		{
			foreach ($this->map as $row)
			{
				echo(implode("", $row) . PHP_EOL);
			}

			echo(PHP_EOL);
		}

		public function reset(): void
		{
			$this->position = new Position2d();
		}

		public function move(int $right, int $down): void
		{
			$this->position->y += $down;
			$this->position->x += $right;

			if ($this->position->x >= $this->width)
			{
				$this->position->x -= $this->width;
			}
		}

		public function process(int $right, int $down): int
		{
			$this->reset();
			$count = 0;

			while ($this->position->y < $this->height)
			{
				if ($this->map[$this->position->y][$this->position->x] === "#")
				{
					$count++;
				}

				$this->move($right, $down);
			}

			return $count;
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			$result->part1 = $this->process(3, 1);

			$slopes = [
				$this->process(1, 1),
				$this->process(3, 1),
				$this->process(5, 1),
				$this->process(7, 1),
				$this->process(1, 2),
			];

			$result->part2 = array_product($slopes);

			return $result;
		}
	}
?>

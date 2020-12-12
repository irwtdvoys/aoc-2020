<?php
	namespace App\Ferry;

	use App\Utils\CompassDirections as Directions;
	use App\Utils\Position2d;

	class Turtle
	{
		public Position2d $position;
		public string $direction;

		public function __construct()
		{
			$this->position = new Position2d();
			$this->direction = Directions::EAST;
		}

		public function move(string $direction, int $distance): void
		{
			switch ($direction)
			{
				case Directions::NORTH:
					$this->position->y += $distance;
					break;
				case Directions::EAST:
					$this->position->x += $distance;
					break;
				case Directions::SOUTH:
					$this->position->y -= $distance;
					break;
				case Directions::WEST:
					$this->position->x -= $distance;
					break;
			}
		}

		public function turn($direction, int $degrees): void
		{
			$steps = $degrees / 90;

			for ($loop = 0; $loop < $steps; $loop++)
			{
				switch ($direction)
				{
					case "L":

						switch ($this->direction)
						{
							case Directions::NORTH:
								$this->direction = Directions::WEST;
								break;
							case Directions::EAST:
								$this->direction = Directions::NORTH;
								break;
							case Directions::SOUTH:
								$this->direction = Directions::EAST;
								break;
							case Directions::WEST:
								$this->direction = Directions::SOUTH;
								break;
						}

						break;
					case "R":

						switch ($this->direction)
						{
							case Directions::NORTH:
								$this->direction = Directions::EAST;
								break;
							case Directions::EAST:
								$this->direction = Directions::SOUTH;
								break;
							case Directions::SOUTH:
								$this->direction = Directions::WEST;
								break;
							case Directions::WEST:
								$this->direction = Directions::NORTH;
								break;
						}

						break;
				}
			}
		}

		public function manhattanDistance(): int
		{
			return abs($this->position->x) + abs($this->position->y);
		}
	}
?>

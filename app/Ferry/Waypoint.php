<?php
	namespace App\Ferry;

	use App\Utils\CompassDirections as Directions;
	use App\Utils\Position2d;

	class Waypoint
	{
		public Position2d $position;

		public function __construct(int $x = 0, int $y = 0)
		{
			$this->position = new Position2d($x, $y);
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
				default:
					echo("Unknown direction");
					die();
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
						$this->position = new Position2d(-$this->position->y, $this->position->x);
						break;
					case "R":
						$this->position = new Position2d($this->position->y, -$this->position->x);
						break;
				}
			}
		}
	}
?>

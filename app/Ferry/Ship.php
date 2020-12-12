<?php
	namespace App\Ferry;

	use App\Utils\Position2d;

	class Ship
	{
		public Position2d $position;

		public function __construct(int $x = 0, int $y = 0)
		{
			$this->position = new Position2d($x, $y);
		}

		public function move(Waypoint $waypoint, int $steps): void
		{
			for ($loop = 0; $loop < $steps; $loop++)
			{
				$this->position->x += $waypoint->position->x;
				$this->position->y += $waypoint->position->y;
			}
		}

		public function manhattanDistance(): int
		{
			return abs($this->position->x) + abs($this->position->y);
		}
	}
?>

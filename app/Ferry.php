<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\Ferry\Ship;
	use App\Ferry\Turtle;
	use App\Ferry\Waypoint;
	use App\Utils\CompassDirections as Directions;

	class Ferry extends Helper
	{
		public Turtle $turtle;

		public Ship $ship;
		public Waypoint $waypoint;

		public array $instructions = [];

		public function __construct(int $day, bool $verbose = false, string $override = null)
		{
			parent::__construct($day, $verbose);

			$this->turtle = new Turtle();

			$this->ship = new Ship(0, 0);
			$this->waypoint = new Waypoint(10, 1);

			$this->instructions = array_map(
				function($element)
				{
					return (object)[
						"action" => $element[0],
						"value" => (int)substr($element, 1)
					];
				},
				explode(PHP_EOL, parent::load($override))
			);
		}

		public function run(): Result
		{
			foreach ($this->instructions as $instruction)
			{
				switch ($instruction->action)
				{
					case Directions::NORTH:
					case Directions::EAST:
					case Directions::SOUTH:
					case Directions::WEST:
						$this->turtle->move($instruction->action, $instruction->value);
						$this->waypoint->move($instruction->action, $instruction->value);
						break;
					case "L":
					case "R":
						$this->turtle->turn($instruction->action, $instruction->value);
						$this->waypoint->turn($instruction->action, $instruction->value);
						break;
					case "F":
						$this->turtle->move($this->turtle->direction, $instruction->value);
						$this->ship->move($this->waypoint, $instruction->value);
						break;
				}
			}

			return new Result($this->turtle->manhattanDistance(), $this->ship->manhattanDistance());
		}
	}
?>

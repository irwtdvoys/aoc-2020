<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\Ferry\Ship;
	use App\Ferry\Turtle;
	use App\Ferry\Waypoint;
	use App\Utils\CompassDirections as Directions;
	use Bolt\Maths;

	class Timetable extends Helper
	{
		public int $timestamp;
		public array $buses = [];

		public function __construct(int $day, bool $verbose = false, string $override = null)
		{
			parent::__construct($day, $verbose);

			list($timestamp, $buses) = explode(PHP_EOL, parent::load($override), 2);

			$this->timestamp = (int)$timestamp;
			$this->buses = array_map(
				function($element)
				{
					return $element === "x" ? "x" : (int)$element;
				},
				explode(",", $buses)
			);
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			$earliest = PHP_INT_MAX;
			$earliestBus = 0;

			$numbers = [];
			$remainders = [];

			for ($loop = 0; $loop < count($this->buses); $loop++)
			{
				$bus = $this->buses[$loop];

				if ($bus === "x")
				{
					continue;
				}

				$numbers[] = $bus;
				$remainders[] = ($bus - $loop) % $bus;

				$next = (floor($this->timestamp / $bus) * $bus) + $bus;

				if ($next < $earliest)
				{
					$earliest = $next;
					$earliestBus = $bus;
				}
			}

			$result->part1 = ($earliest - $this->timestamp) * $earliestBus;
			$result->part2 = Maths::crt($numbers, $remainders);

			return $result;
		}
	}
?>

<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\PassportProcessing\Passport;
	use Bolt\Curl;

	class Customs extends Helper
	{
		public array $groups;

		public function __construct(int $day, bool $verbose = false, string $override = null)
		{
			parent::__construct($day, $verbose);

			$this->groups = array_map(
				function($element)
				{
					return array_map(
						function ($answers)
						{
							return str_split($answers);
						},
						explode(PHP_EOL, $element)
					);
				},
				explode(str_repeat(PHP_EOL, 2), parent::load($override))
			);
		}

		public function run(): Result
		{
			$result = new Result(0, 0);


			foreach ($this->groups as $group)
			{
				$allAnswers = [];
				$commonAnswers = null;

				foreach ($group as $person)
				{
					$allAnswers = array_merge($allAnswers, $person);

					$commonAnswers = ($commonAnswers === null) ? $person : array_intersect($commonAnswers, $person);
				}

				$unique = array_unique($allAnswers);
				$result->part1 += count($unique);

				$unique = array_unique($commonAnswers);
				$result->part2 += count($unique);
			}

			return $result;
		}
	}
?>

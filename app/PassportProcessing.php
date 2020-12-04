<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\PassportProcessing\Passport;

	class PassportProcessing extends Helper
	{
		public array $passports;

		public function __construct(int $day, string $override = null)
		{
			parent::__construct($day);

			$this->passports = array_map(
				function($element)
				{
					return new Passport($element);
				},
				explode(str_repeat(PHP_EOL, 2), parent::load($override))
			);
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			foreach ($this->passports as $passport)
			{
				if ($passport->isValid())
				{
					$result->part1++;
				}

				if ($passport->isValid(true))
				{
					$result->part2++;
				}
			}

			return $result;
		}
	}
?>

<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\PasswordPolicy\Password;

	class PasswordPolicy extends Helper
	{
		public array $data;

		public function __construct(int $day, bool $verbose = false, string $override = null)
		{
			parent::__construct($day, $verbose);

			$this->data = array_map(
				function($element)
				{
					return new Password($element);
				},
				explode(PHP_EOL, parent::load($override))
			);
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			foreach ($this->data as $password)
			{
				if ($password->isValidSled())
				{
					$result->part1++;
				}
			}

			foreach ($this->data as $password)
			{
				if ($password->isValidToboggan())
				{
					$result->part2++;
				}
			}

			return $result;
		}
	}
?>

<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\PassportProcessing\Passport;
	use Bolt\Curl;

	class Partitioning extends Helper
	{
		public array $data;

		public function __construct(int $day, string $override = null)
		{
			parent::__construct($day);

			$this->data = explode(PHP_EOL, parent::load($override));
		}

		private function process($data)
		{
			$binary = str_replace(["F", "B", "L", "R"], [0, 1, 0, 1], $data);

			return intval($binary, 2);
		}

		public function run(): Result
		{
			$ids = [];

			foreach ($this->data as $next)
			{
				$ids[] = $this->process($next);
			}

			sort($ids);

			$first = $ids[0];
			$last = $ids[count($ids) - 1];

			$total = array_sum($ids);
			$expectedTotal = ($last - $first + 1) * (($first + $last) / 2);

			return new Result(max($ids), $expectedTotal - $total);
		}
	}
?>

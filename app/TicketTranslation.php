<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\TicketTranslation\Rule;

	class TicketTranslation extends Helper
	{
		public array $rules;
		public array $ticket;
		public array $nearby;

		public function __construct(int $day, bool $verbose = false, string $override = null)
		{
			parent::__construct($day, $verbose);

			$raw = parent::load($override);

			list($data, $your, $nearby) = preg_split("/\n\nyour ticket:\n|\n\nnearby tickets:\n/", $raw);

			$this->ticket = array_map("intval", explode(",", $your));
			$this->nearby = array_map(
				function($element)
				{
					return array_map("intval", explode(",", $element));
				},
				explode(PHP_EOL, $nearby)
			);

			$this->rules = array_map(
				function($element)
				{
					return new Rule($element);
				},
				explode(PHP_EOL, $data)
			);
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			$invalid = [];

			$tickets = [$this->ticket];

			foreach ($this->nearby as $ticket)
			{
				$validTicket = true;

				foreach ($ticket as $value)
				{
					$isValid = false;

					foreach ($this->rules as $rule)
					{
						if ($rule->isValid($value))
						{
							$isValid = true;
							break;
						}
					}

					if ($isValid === false)
					{
						$validTicket = false;
						$invalid[] = $value;
					}
				}

				if ($validTicket === true)
				{
					$tickets[] = $ticket;
				}
			}

			$result->part1 = array_sum($invalid);

			dump($tickets);



			return $result;
		}
	}
?>

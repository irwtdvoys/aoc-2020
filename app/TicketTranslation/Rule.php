<?php
	namespace App\TicketTranslation;


	class Rule
	{
		public string $label;
		/** @var Range[] */
		public array $ranges = [];

		public function __construct(string $data)
		{
			preg_match("/^(?'label'[a-z ]+): (?'oneMin'\d+)-(?'oneMax'\d+) or (?'twoMin'\d+)-(?'twoMax'\d+)$/m", $data, $matches);

			$this->label = $matches['label'];
			$this->ranges[] = new Range($matches['oneMin'], $matches['oneMax']);
			$this->ranges[] = new Range($matches['twoMin'], $matches['twoMax']);
		}

		public function isValid(int $value): bool
		{
			foreach ($this->ranges as $range)
			{
				if ($value >= $range->min && $value <= $range->max)
				{
					return true;
				}
			}

			return false;
		}

		public function validateGroup(array $group): bool
		{
			foreach ($group as $item)
			{
				if (!$this->isValid($item))
				{
					return false;
				}
			}

			return true;
		}
	}
?>

<?php
	namespace App\TicketTranslation;

	class Range
	{
		public int $min;
		public int $max;

		public function __construct(int $min, int $max)
		{
			$this->min = $min;
			$this->max = $max;
		}
	}
?>

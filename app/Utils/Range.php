<?php
	namespace App\Utils;

	class Range
	{
		public int $min;
		public int $max;

		public function __construct(int $min, int $max)
		{
			$this->min = $min;
			$this->max = $max;
		}

		public function add(int $value): void
		{
			$this->min = min($this->min, $value);
			$this->max = max($this->max, $value);
		}
	}
?>

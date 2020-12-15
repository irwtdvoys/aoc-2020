<?php
	namespace App\Bitmasking;

	class Instruction
	{
		public int $location;
		public int $value;

		public function __construct(string $data)
		{
			preg_match("/mem\[(\d+)] = (\d+)/", $data, $matches);

			$this->location = $matches[1];
			$this->value = $matches[2];
		}
	}
?>

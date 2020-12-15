<?php
	namespace App\Bitmasking;

	class Program
	{
		public string $mask;
		public array $instructions = [];

		public function __construct($data)
		{
			$lines = explode(PHP_EOL, $data);

			$this->mask = substr(array_shift($lines), 7);

			$this->instructions = array_map(
				function($element)
				{
					return new Instruction($element);
				},
				$lines
			);
		}
	}
?>
